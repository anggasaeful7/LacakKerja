<?php

use App\Enums\InvoiceStatus;
use App\Enums\NotificationEvent;
use App\Enums\OrganizationRole;
use App\Enums\PaymentMethod;
use App\Enums\WorkOrderStatus;
use App\Jobs\DeliverNotificationEmail;
use App\Mail\NotificationMail;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\NotificationPreference;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignment;
use App\Notifications\FieldServiceNotification;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use RuntimeException;

function m10Fixture(): array
{
    $organization = Organization::factory()->create(['timezone' => 'Asia/Jakarta', 'currency' => 'IDR']);
    $owner = User::factory()->create(['current_organization_id' => $organization->id]);
    $technician = User::factory()->create(['current_organization_id' => $organization->id]);
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->create(['organization_id' => $organization->id, 'customer_id' => $customer->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $workOrder = WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => now()->addHour(),
        'scheduled_end' => now()->addHours(2),
        'sla_due_at' => now()->addHours(4),
    ]);

    return compact('organization', 'owner', 'technician', 'customer', 'site', 'service', 'workOrder');
}

it('writes assignment notifications and queues email delivery', function () {
    Queue::fake();
    $fixture = m10Fixture();

    WorkOrderAssignment::factory()->create([
        'work_order_id' => $fixture['workOrder']->id,
        'user_id' => $fixture['technician']->id,
        'is_primary' => true,
    ]);

    expect($fixture['technician']->notifications()->where('data->event', NotificationEvent::Assigned->value)->count())->toBe(1);
    Queue::assertPushed(DeliverNotificationEmail::class, fn (DeliverNotificationEmail $job): bool => $job->userId === $fixture['technician']->id && $job->organizationId === $fixture['organization']->id);
    expect(ActivityLog::query()->where('event', 'work_order.assigned')->where('organization_id', $fixture['organization']->id)->exists())->toBeTrue();
});

it('respects per-event in-app and email preferences', function () {
    Queue::fake();
    $fixture = m10Fixture();
    NotificationPreference::factory()->create([
        'organization_id' => $fixture['organization']->id,
        'user_id' => $fixture['technician']->id,
        'event' => NotificationEvent::Assigned,
        'in_app' => false,
        'email' => false,
    ]);

    WorkOrderAssignment::factory()->create([
        'work_order_id' => $fixture['workOrder']->id,
        'user_id' => $fixture['technician']->id,
        'is_primary' => true,
    ]);

    expect($fixture['technician']->notifications()->where('data->event', NotificationEvent::Assigned->value)->count())->toBe(0);
    Queue::assertNotPushed(DeliverNotificationEmail::class);
});

it('scopes notification center by tenant and supports read state', function () {
    $fixture = m10Fixture();
    $otherOrganization = Organization::factory()->create();
    Membership::factory()->create(['organization_id' => $otherOrganization->id, 'user_id' => $fixture['owner']->id, 'role' => OrganizationRole::Dispatcher]);

    $fixture['owner']->notify(new FieldServiceNotification($fixture['organization'], NotificationEvent::Completed, [
        'title' => 'Pekerjaan selesai',
        'body' => 'WO tenant utama',
        'route' => route('dashboard'),
    ]));
    $fixture['owner']->notify(new FieldServiceNotification($otherOrganization, NotificationEvent::Completed, [
        'title' => 'Tenant lain',
        'body' => 'Tidak boleh tampil',
        'route' => route('dashboard'),
    ]));

    $response = $this->actingAs($fixture['owner'])->get(route('notifications.index'));
    $response->assertOk()->assertSee('WO tenant utama')->assertDontSee('Tidak boleh tampil');

    $notification = $fixture['owner']->notifications()->where('data->organization_id', $fixture['organization']->id)->firstOrFail();
    $this->actingAs($fixture['owner'])->patch(route('notifications.read', $notification->id))->assertRedirect();
    expect($notification->fresh()->read_at)->not->toBeNull();
});

it('redacts sensitive audit values and records role and payment changes', function () {
    Queue::fake();
    $fixture = m10Fixture();
    $audit = app(AuditLogger::class)->log('test.sensitive', $fixture['workOrder'], changes: [
        'password' => 'plain-password',
        'api_token' => 'secret-token',
        'file_content' => 'private file bytes',
        'title' => 'safe value',
    ]);

    expect($audit->changes)->toMatchArray([
        'password' => '[REDACTED]',
        'api_token' => '[REDACTED]',
        'file_content' => '[REDACTED]',
        'title' => 'safe value',
    ]);

    $member = Membership::query()->where('organization_id', $fixture['organization']->id)->where('user_id', $fixture['technician']->id)->firstOrFail();
    $member->update(['role' => OrganizationRole::Dispatcher]);
    expect(ActivityLog::query()->where('event', 'membership.role_changed')->where('subject_id', $member->id)->exists())->toBeTrue();

    $fixture['workOrder']->update(['status' => WorkOrderStatus::Completed]);
    $fixture['workOrder']->update(['status' => WorkOrderStatus::InProgress]);
    expect(ActivityLog::query()->where('event', 'work_order.reopened')->where('subject_id', $fixture['workOrder']->id)->exists())->toBeTrue();

    $invoice = Invoice::factory()->issued()->create([
        'organization_id' => $fixture['organization']->id,
        'customer_id' => $fixture['customer']->id,
        'total_amount' => 500000,
        'amount_due' => 500000,
    ]);
    Payment::factory()->create([
        'organization_id' => $fixture['organization']->id,
        'invoice_id' => $invoice->id,
        'received_by' => $fixture['owner']->id,
        'amount' => 100000,
        'method' => PaymentMethod::BankTransfer,
    ]);
    expect(ActivityLog::query()->where('event', 'invoice.payment_recorded')->where('organization_id', $fixture['organization']->id)->exists())->toBeTrue();

    $invoice->update(['status' => InvoiceStatus::Void]);
    expect(ActivityLog::query()->where('event', 'invoice.void')->where('subject_id', $invoice->id)->exists())->toBeTrue();
});

it('records failed email delivery for retry visibility without duplicating in-app notification', function () {
    $fixture = m10Fixture();
    $job = new DeliverNotificationEmail($fixture['technician']->id, $fixture['organization']->id, NotificationEvent::Assigned->value, [
        'title' => 'Test email',
        'body' => 'Test',
    ]);

    $job->failed(new RuntimeException('SMTP unavailable'));

    expect(ActivityLog::query()->where('event', 'notification.email_failed')->where('organization_id', $fixture['organization']->id)->exists())->toBeTrue();
});

it('sends overdue and invoice due reminders once per day', function () {
    Queue::fake();
    $fixture = m10Fixture();
    $fixture['workOrder']->update(['sla_due_at' => now()->subHour(), 'status' => WorkOrderStatus::InProgress]);
    $invoice = Invoice::factory()->issued()->create([
        'organization_id' => $fixture['organization']->id,
        'customer_id' => $fixture['customer']->id,
        'due_date' => now()->toDateString(),
        'total_amount' => 750000,
        'amount_due' => 750000,
    ]);

    Artisan::call('lacakkerja:send-reminders');
    Artisan::call('lacakkerja:send-reminders');

    expect(ActivityLog::query()->where('event', 'work_order.overdue')->where('subject_id', $fixture['workOrder']->id)->count())->toBe(1)
        ->and(ActivityLog::query()->where('event', 'invoice.due')->where('subject_id', $invoice->id)->count())->toBe(1)
        ->and($fixture['owner']->notifications()->where('data->event', NotificationEvent::Overdue->value)->count())->toBe(1)
        ->and($fixture['owner']->notifications()->where('data->event', NotificationEvent::InvoiceDue->value)->count())->toBe(1);
});

it('renders preferences and owner-only audit log', function () {
    $fixture = m10Fixture();

    $this->actingAs($fixture['owner'])->get(route('notifications.preferences.edit'))->assertOk()->assertSee('Preferensi notifikasi');
    $this->actingAs($fixture['owner'])->put(route('notifications.preferences.update'), [
        'preferences' => [
            NotificationEvent::Assigned->value => ['in_app' => '1'],
        ],
    ])->assertRedirect();
    expect(NotificationPreference::query()->where('organization_id', $fixture['organization']->id)->where('user_id', $fixture['owner']->id)->where('event', NotificationEvent::Assigned->value)->value('email'))->toBeFalse();
    $this->actingAs($fixture['owner'])->get(route('audit.index'))->assertOk()->assertSee('Audit log');
    $this->actingAs($fixture['technician'])->get(route('audit.index'))->assertForbidden();
});

it('sends notification mail when the queued delivery job runs', function () {
    Mail::fake();
    $fixture = m10Fixture();
    $job = new DeliverNotificationEmail($fixture['technician']->id, $fixture['organization']->id, NotificationEvent::Assigned->value, [
        'title' => 'Assignment baru',
        'body' => 'WO-123',
        'route' => route('dashboard'),
    ]);

    $job->handle();

    Mail::assertSent(NotificationMail::class, fn (NotificationMail $mail): bool => $mail->title === 'Assignment baru');
});
