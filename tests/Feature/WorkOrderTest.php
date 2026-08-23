<?php

use App\Enums\ChecklistInputType;
use App\Enums\ChecklistStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use App\Services\WorkOrderService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function makeWorkOrderFixture(array $organizationSettings = []): array
{
    $organization = Organization::factory()->create(['settings' => $organizationSettings]);
    $owner = User::factory()->create();
    $dispatcher = User::factory()->create();
    $technician = User::factory()->create();

    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    $owner->update(['current_organization_id' => $organization->id]);

    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $template = ChecklistTemplate::factory()->forService($service)->create([
        'organization_id' => $organization->id,
        'status' => ChecklistStatus::Published,
        'is_current' => true,
    ]);
    ChecklistTemplateItem::factory()->create([
        'checklist_template_id' => $template->id,
        'position' => 1,
        'input_type' => ChecklistInputType::Checkbox,
        'is_required' => true,
        'photo_required' => false,
    ]);

    $workOrder = WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'created_by' => $dispatcher->id,
        'status' => WorkOrderStatus::Draft,
        'priority' => WorkOrderPriority::Normal,
    ]);

    $workOrder->assignments()->create([
        'user_id' => $technician->id,
        'is_primary' => true,
        'assigned_at' => now(),
    ]);
    app(WorkOrderService::class)->snapshotChecklist($workOrder);

    return compact('organization', 'owner', 'dispatcher', 'technician', 'customer', 'site', 'service', 'workOrder');
}

it('creates a scheduled work order and snapshots the selected checklist', function () {
    $fixture = makeWorkOrderFixture();
    $workOrder = $fixture['workOrder'];

    $response = $this->actingAs($fixture['dispatcher'])->post(route('work-orders.store'), [
        'customer_id' => $fixture['customer']->id,
        'customer_site_id' => $fixture['site']->id,
        'service_id' => $fixture['service']->id,
        'technician_id' => $fixture['technician']->id,
        'title' => 'Pemeriksaan AC lantai 12',
        'description' => 'Unit tidak dingin.',
        'priority' => WorkOrderPriority::High->value,
        'scheduled_start' => now()->addDay()->setTime(9, 0)->format('Y-m-d\TH:i'),
        'scheduled_end' => now()->addDay()->setTime(11, 0)->format('Y-m-d\TH:i'),
        'sla_due_at' => now()->addDay()->setTime(17, 0)->format('Y-m-d\TH:i'),
        'estimated_total' => 850000,
    ]);

    $response->assertRedirect();
    $created = WorkOrder::query()->where('title', 'Pemeriksaan AC lantai 12')->firstOrFail();

    expect($created->number)->toStartWith('WO-'.now()->format('Y').'-')
        ->and($created->status)->toBe(WorkOrderStatus::Scheduled)
        ->and($created->assignments()->where('user_id', $fixture['technician']->id)->where('is_primary', true)->exists())->toBeTrue()
        ->and($created->checklistItems()->count())->toBe(1)
        ->and($created->statusHistories()->latest('id')->value('to_status'))->toBe(WorkOrderStatus::Scheduled);

    $workOrder->delete();
});

it('requires a reason and writes status history for cancellation', function () {
    $fixture = makeWorkOrderFixture();
    $workOrder = $fixture['workOrder'];

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::Cancelled->value,
        ])
        ->assertSessionHasErrors('reason');

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::Cancelled->value,
            'reason' => 'Pelanggan membatalkan pekerjaan.',
        ])
        ->assertRedirect();

    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::Cancelled)
        ->and($workOrder->statusHistories()->latest('id')->value('reason'))->toBe('Pelanggan membatalkan pekerjaan.');
});

it('blocks completion until checklist, note, and active time log requirements are met', function () {
    $fixture = makeWorkOrderFixture();
    $workOrder = $fixture['workOrder'];
    $workOrder->update(['status' => WorkOrderStatus::InProgress]);
    $item = $workOrder->checklistItems()->firstOrFail();
    $timeLog = TimeLog::factory()->active()->create(['work_order_id' => $workOrder->id, 'user_id' => $fixture['technician']->id]);

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.complete', $workOrder))
        ->assertSessionHasErrors('completion');

    $item->update(['value' => ['value' => true], 'completed_by' => $fixture['technician']->id, 'completed_at' => now()]);
    $workOrder->notes()->create(['user_id' => $fixture['technician']->id, 'visibility' => 'internal', 'body' => 'Pekerjaan sudah diuji.']);
    app(WorkOrderService::class)->stopTimeLog($timeLog, $fixture['technician']);

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.complete', $workOrder))
        ->assertRedirect();

    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::Completed)
        ->and($workOrder->fresh()->completed_at)->not->toBeNull()
        ->and($workOrder->statusHistories()->latest('id')->value('to_status'))->toBe(WorkOrderStatus::Completed);
});

it('restricts technicians to their own tenant work orders', function () {
    $tenantA = makeWorkOrderFixture();
    $tenantB = makeWorkOrderFixture();

    $this->actingAs($tenantA['technician'])
        ->get(route('work-orders.show', $tenantA['workOrder']))
        ->assertOk();

    $this->actingAs($tenantA['technician'])
        ->get(route('work-orders.show', $tenantB['workOrder']))
        ->assertForbidden();

    $this->actingAs($tenantA['technician'])
        ->post(route('work-orders.transition', $tenantB['workOrder']), [
            'status' => WorkOrderStatus::InProgress->value,
        ])
        ->assertForbidden();
});

it('stores attachments on the private disk and prevents cross-tenant download', function () {
    Storage::fake('local');
    $tenantA = makeWorkOrderFixture();
    $tenantB = makeWorkOrderFixture();

    $this->actingAs($tenantA['owner'])
        ->post(route('work-orders.attachments.store', $tenantA['workOrder']), [
            'file' => UploadedFile::fake()->image('before.jpg'),
            'category' => 'before',
        ])
        ->assertRedirect();

    $attachment = $tenantA['workOrder']->attachments()->firstOrFail();
    Storage::disk('local')->assertExists($attachment->path);

    $this->actingAs($tenantA['owner'])
        ->get(route('work-orders.attachments.download', [$tenantB['workOrder'], $tenantB['workOrder']->attachments()->create([
            'uploaded_by' => $tenantB['owner']->id,
            'category' => 'evidence',
            'disk' => 'local',
            'path' => 'other/evidence.jpg',
            'original_name' => 'evidence.jpg',
            'mime_type' => 'image/jpeg',
            'size_bytes' => 10,
        ])]))
        ->assertForbidden();
});

it('rejects invalid state transitions and allows the valid dispatch path', function () {
    $fixture = makeWorkOrderFixture();
    $workOrder = $fixture['workOrder'];

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::EnRoute->value,
        ])
        ->assertSessionHasErrors('status');

    $workOrder->update([
        'scheduled_start' => now()->addHour(),
        'scheduled_end' => now()->addHours(3),
    ]);

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::Scheduled->value,
        ])
        ->assertRedirect();

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::Dispatched->value,
        ])
        ->assertRedirect();

    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::Dispatched);
});

it('allows only an admin role to reopen a completed work order with a reason', function () {
    $fixture = makeWorkOrderFixture();
    $workOrder = $fixture['workOrder'];
    $workOrder->update(['status' => WorkOrderStatus::Completed, 'completed_at' => now()]);
    $workOrder->statusHistories()->create([
        'changed_by' => $fixture['owner']->id,
        'from_status' => WorkOrderStatus::InProgress,
        'to_status' => WorkOrderStatus::Completed,
        'reason' => null,
        'created_at' => now(),
    ]);

    $this->actingAs($fixture['technician'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::InProgress->value,
            'reason' => 'Perlu perbaikan ulang.',
        ])
        ->assertForbidden();

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::InProgress->value,
        ])
        ->assertSessionHasErrors('reason');

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.transition', $workOrder), [
            'status' => WorkOrderStatus::InProgress->value,
            'reason' => 'Perlu perbaikan ulang.',
        ])
        ->assertRedirect();

    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::InProgress)
        ->and($workOrder->fresh()->completed_at)->toBeNull()
        ->and($workOrder->statusHistories()->latest('id')->value('from_status'))->toBe(WorkOrderStatus::Completed);
});
