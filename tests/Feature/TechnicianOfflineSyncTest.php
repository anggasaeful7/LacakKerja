<?php

use App\Enums\ChecklistInputType;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\SyncOperation;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function makeOfflineSyncFixture(): array
{
    $organization = Organization::factory()->create();
    $technician = User::factory()->create(['current_organization_id' => $organization->id]);
    $dispatcher = User::factory()->create(['current_organization_id' => $organization->id]);
    $otherOrganization = Organization::factory()->create();
    $otherTechnician = User::factory()->create(['current_organization_id' => $otherOrganization->id]);

    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->create(['organization_id' => $otherOrganization->id, 'user_id' => $otherTechnician->id, 'role' => OrganizationRole::Technician]);

    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);

    return compact('organization', 'technician', 'dispatcher', 'otherOrganization', 'otherTechnician', 'customer', 'site', 'service');
}

function makeOfflineSyncWorkOrder(array $fixture, array $attributes = []): WorkOrder
{
    return WorkOrder::factory()->forCustomer($fixture['customer'], $fixture['site'])->create(array_merge([
        'organization_id' => $fixture['organization']->id,
        'service_id' => $fixture['service']->id,
        'created_by' => $fixture['dispatcher']->id,
        'status' => WorkOrderStatus::InProgress,
        'priority' => WorkOrderPriority::Normal,
        'number' => 'WO-SYNC-'.fake()->unique()->numerify('######'),
    ], $attributes));
}

function assignOfflineSyncWorkOrder(WorkOrder $workOrder, User $technician): void
{
    $workOrder->assignments()->create(['user_id' => $technician->id, 'is_primary' => true, 'assigned_at' => now()]);
}

it('returns only assigned technician data from the offline bootstrap', function () {
    $fixture = makeOfflineSyncFixture();
    $own = makeOfflineSyncWorkOrder($fixture, ['number' => 'WO-SYNC-OWN']);
    assignOfflineSyncWorkOrder($own, $fixture['technician']);
    $other = makeOfflineSyncWorkOrder($fixture, ['number' => 'WO-SYNC-OTHER']);
    assignOfflineSyncWorkOrder($other, $fixture['otherTechnician']);
    WorkOrderChecklistItem::factory()->create(['work_order_id' => $own->id, 'input_type' => ChecklistInputType::Checkbox]);

    $this->actingAs($fixture['technician'])
        ->getJson(route('technician.sync.bootstrap'))
        ->assertOk()
        ->assertJsonPath('scope.organization_id', $fixture['organization']->id)
        ->assertJsonFragment(['number' => 'WO-SYNC-OWN'])
        ->assertJsonMissing(['number' => 'WO-SYNC-OTHER']);

    $this->actingAs($fixture['dispatcher'])->get(route('technician.sync.center'))->assertForbidden();
});

it('syncs checklist and notes idempotently', function () {
    $fixture = makeOfflineSyncFixture();
    $workOrder = makeOfflineSyncWorkOrder($fixture);
    assignOfflineSyncWorkOrder($workOrder, $fixture['technician']);
    $item = WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'input_type' => ChecklistInputType::Checkbox]);
    $operationId = (string) Str::uuid();

    $checklistOperation = [
        'client_operation_id' => $operationId,
        'type' => 'checklist.update',
        'work_order_id' => $workOrder->id,
        'base_version' => 1,
        'payload' => ['item_id' => $item->id, 'value' => '1'],
    ];
    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$checklistOperation]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'synced');

    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$checklistOperation]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'synced');

    $noteOperation = [
        'client_operation_id' => (string) Str::uuid(),
        'type' => 'note.create',
        'work_order_id' => $workOrder->id,
        'base_version' => 2,
        'payload' => ['body' => 'Dikirim setelah koneksi pulih.', 'visibility' => 'internal'],
    ];
    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$noteOperation]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'synced');

    expect($workOrder->fresh()->lock_version)->toBe(3)
        ->and($item->fresh()->isComplete())->toBeTrue()
        ->and($workOrder->notes()->count())->toBe(1)
        ->and(SyncOperation::query()->where('user_id', $fixture['technician']->id)->count())->toBe(2);
});

it('returns conflict and allows a new operation to retry against the server version', function () {
    $fixture = makeOfflineSyncFixture();
    $workOrder = makeOfflineSyncWorkOrder($fixture);
    assignOfflineSyncWorkOrder($workOrder, $fixture['technician']);
    $item = WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'input_type' => ChecklistInputType::Text]);
    $workOrder->forceFill(['lock_version' => 2])->save();
    $conflicting = [
        'client_operation_id' => (string) Str::uuid(),
        'type' => 'checklist.update',
        'work_order_id' => $workOrder->id,
        'base_version' => 1,
        'payload' => ['item_id' => $item->id, 'value' => 'Catatan lokal'],
    ];

    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$conflicting]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'conflict')
        ->assertJsonPath('results.0.server_version', 2);

    $retry = $conflicting;
    $retry['client_operation_id'] = (string) Str::uuid();
    $retry['base_version'] = 2;
    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$retry]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'synced');

    expect($item->fresh()->value)->toBe(['value' => 'Catatan lokal'])
        ->and($workOrder->fresh()->lock_version)->toBe(3);
});

it('rejects a batch operation for a work order not assigned to the technician', function () {
    $fixture = makeOfflineSyncFixture();
    $workOrder = makeOfflineSyncWorkOrder($fixture);
    $operation = [
        'client_operation_id' => (string) Str::uuid(),
        'type' => 'note.create',
        'work_order_id' => $workOrder->id,
        'base_version' => 1,
        'payload' => ['body' => 'Tidak boleh masuk.', 'visibility' => 'internal'],
    ];

    $this->actingAs($fixture['technician'])
        ->postJson(route('technician.sync.batch'), ['operations' => [$operation]])
        ->assertOk()
        ->assertJsonPath('results.0.state', 'failed')
        ->assertJsonPath('results.0.code', 'not_found');

    expect($workOrder->notes()->count())->toBe(0);
});

it('deduplicates a pending photo upload by client id', function () {
    Storage::fake('local');
    $fixture = makeOfflineSyncFixture();
    $workOrder = makeOfflineSyncWorkOrder($fixture);
    assignOfflineSyncWorkOrder($workOrder, $fixture['technician']);
    $clientUploadId = (string) Str::uuid();

    foreach (['evidence-a.jpg', 'evidence-a-retry.jpg'] as $filename) {
        $this->actingAs($fixture['technician'])->post(route('technician.work-orders.photos.store', $workOrder), [
            'file' => UploadedFile::fake()->image($filename),
            'category' => 'evidence',
            'client_upload_id' => $clientUploadId,
        ])->assertRedirect();
    }

    expect($workOrder->attachments()->where('client_upload_id', $clientUploadId)->count())->toBe(1);
});
