<?php

use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use App\Services\InvoiceCalculator;

function makeInvoiceFixture(): array
{
    $organization = Organization::factory()->create(['currency' => 'IDR']);
    $owner = User::factory()->create(['current_organization_id' => $organization->id]);
    $dispatcher = User::factory()->create(['current_organization_id' => $organization->id]);
    $otherOrganization = Organization::factory()->create();
    $otherOwner = User::factory()->create(['current_organization_id' => $otherOrganization->id]);

    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->owner()->create(['organization_id' => $otherOrganization->id, 'user_id' => $otherOwner->id]);

    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id, 'base_price' => 850000]);
    $workOrder = WorkOrder::factory()->forCustomer($customer, $site)->completed()->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'created_by' => $dispatcher->id,
        'status' => WorkOrderStatus::Completed,
        'estimated_total' => 1000000,
    ]);

    return compact('organization', 'owner', 'dispatcher', 'otherOrganization', 'otherOwner', 'customer', 'site', 'service', 'workOrder');
}

function invoicePayload(array $fixture, array $overrides = []): array
{
    return array_merge([
        'customer_id' => $fixture['customer']->id,
        'work_order_id' => $fixture['workOrder']->id,
        'due_date' => now()->addDays(14)->toDateString(),
        'discount_amount' => 50000,
        'tax_rate' => '11',
        'notes' => 'Pembayaran maksimal 14 hari.',
        'items' => [[
            'service_id' => $fixture['service']->id,
            'description' => 'Preventive maintenance AC',
            'quantity' => '1.500',
            'unit_price' => 1000000,
        ]],
    ], $overrides);
}

it('calculates money with controlled decimal quantity and tax rounding', function () {
    $result = app(InvoiceCalculator::class)->calculate([
        ['description' => 'Jasa', 'quantity' => '1.500', 'unit_price' => 100000],
    ], 10000, '11');

    expect($result['subtotal'])->toBe(150000)
        ->and($result['discount_amount'])->toBe(10000)
        ->and($result['tax_amount'])->toBe(15400)
        ->and($result['total_amount'])->toBe(155400)
        ->and($result['items'][0]['line_total'])->toBe(150000);
});

it('creates invoice from completed work order, issues it, and records partial then full payment', function () {
    $fixture = makeInvoiceFixture();

    $this->actingAs($fixture['owner'])
        ->post(route('invoices.store'), invoicePayload($fixture))
        ->assertRedirect();

    $invoice = Invoice::query()->firstOrFail();
    expect($invoice->number)->toStartWith('INV-'.now()->format('Y').'-')
        ->and($invoice->status)->toBe(InvoiceStatus::Draft)
        ->and($invoice->subtotal)->toBe(1500000)
        ->and($invoice->tax_amount)->toBe(159500)
        ->and($invoice->total_amount)->toBe(1609500);

    $this->actingAs($fixture['owner'])
        ->post(route('invoices.issue', $invoice))
        ->assertRedirect();

    expect($invoice->fresh()->status)->toBe(InvoiceStatus::Issued);

    $this->actingAs($fixture['dispatcher'])
        ->post(route('invoices.payments.store', $invoice), [
            'amount' => 500000,
            'method' => PaymentMethod::BankTransfer->value,
            'paid_at' => now()->format('Y-m-d H:i'),
            'reference' => 'TRX-001',
        ])
        ->assertRedirect();

    expect($invoice->fresh()->status)->toBe(InvoiceStatus::PartiallyPaid)
        ->and($invoice->fresh()->paid_amount)->toBe(500000)
        ->and($invoice->fresh()->amount_due)->toBe(1109500);

    $this->actingAs($fixture['dispatcher'])
        ->post(route('invoices.payments.store', $invoice), [
            'amount' => 1109500,
            'method' => PaymentMethod::Cash->value,
            'paid_at' => now()->format('Y-m-d H:i'),
        ])
        ->assertRedirect();

    expect($invoice->fresh()->status)->toBe(InvoiceStatus::Paid)
        ->and($invoice->fresh()->amount_due)->toBe(0)
        ->and($invoice->payments()->count())->toBe(2);
});

it('rejects overpayment and locks an issued invoice from editing', function () {
    $fixture = makeInvoiceFixture();
    $this->actingAs($fixture['owner'])->post(route('invoices.store'), invoicePayload($fixture))->assertRedirect();
    $invoice = Invoice::query()->firstOrFail();
    $this->actingAs($fixture['owner'])->post(route('invoices.issue', $invoice))->assertRedirect();

    $this->actingAs($fixture['dispatcher'])
        ->post(route('invoices.payments.store', $invoice), ['amount' => 2000000, 'method' => PaymentMethod::Cash->value, 'paid_at' => now()->format('Y-m-d H:i')])
        ->assertSessionHasErrors('amount');

    $this->actingAs($fixture['owner'])
        ->put(route('invoices.update', $invoice), invoicePayload($fixture))
        ->assertForbidden();
});

it('supports void and revision without deleting the original invoice', function () {
    $fixture = makeInvoiceFixture();
    $this->actingAs($fixture['owner'])->post(route('invoices.store'), invoicePayload($fixture))->assertRedirect();
    $invoice = Invoice::query()->firstOrFail();
    $this->actingAs($fixture['owner'])->post(route('invoices.issue', $invoice))->assertRedirect();

    $this->actingAs($fixture['owner'])
        ->post(route('invoices.revise', $invoice))
        ->assertRedirect();

    $revision = Invoice::query()->where('revision_of_id', $invoice->id)->firstOrFail();
    expect($invoice->fresh()->status)->toBe(InvoiceStatus::Void)
        ->and($revision->status)->toBe(InvoiceStatus::Draft)
        ->and($revision->work_order_id)->toBe($fixture['workOrder']->id)
        ->and(Invoice::query()->count())->toBe(2);
});

it('refreshes overdue status and blocks cross-tenant view, payment, and print', function () {
    $fixture = makeInvoiceFixture();
    $this->actingAs($fixture['owner'])->post(route('invoices.store'), invoicePayload($fixture, ['due_date' => now()->subDay()->toDateString()]))->assertRedirect();
    $invoice = Invoice::query()->firstOrFail();
    $this->actingAs($fixture['owner'])->post(route('invoices.issue', $invoice))->assertRedirect();

    $this->actingAs($fixture['owner'])->get(route('invoices.show', $invoice))->assertOk();
    expect($invoice->fresh()->status)->toBe(InvoiceStatus::Overdue);

    $this->actingAs($fixture['otherOwner'])->get(route('invoices.show', $invoice))->assertForbidden();
    $this->actingAs($fixture['otherOwner'])->get(route('invoices.print', $invoice))->assertForbidden();
    $this->actingAs($fixture['otherOwner'])->post(route('invoices.payments.store', $invoice), ['amount' => 10, 'method' => PaymentMethod::Cash->value, 'paid_at' => now()->format('Y-m-d H:i')])->assertForbidden();
});
