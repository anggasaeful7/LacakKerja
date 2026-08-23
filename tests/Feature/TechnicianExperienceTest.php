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
use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function makeTechnicianExperienceFixture(array $settings = []): array
{
    $organization = Organization::factory()->create(['settings' => $settings]);
    $technician = User::factory()->create(['current_organization_id' => $organization->id]);
    $otherTechnician = User::factory()->create();
    $dispatcher = User::factory()->create(['current_organization_id' => $organization->id]);
    $otherOrganization = Organization::factory()->create();
    $otherUser = User::factory()->create(['current_organization_id' => $otherOrganization->id]);

    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $otherTechnician->id, 'role' => OrganizationRole::Technician]);
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->create(['organization_id' => $otherOrganization->id, 'user_id' => $otherUser->id, 'role' => OrganizationRole::Technician]);

    $customer = Customer::factory()->create(['organization_id' => $organization->id, 'phone' => '+62 811 1111 2222']);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id, 'city' => 'Jakarta Selatan', 'contact_phone' => '+62 811 3333 4444']);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $today = now()->startOfDay();

    return compact('organization', 'technician', 'otherTechnician', 'dispatcher', 'otherOrganization', 'otherUser', 'customer', 'site', 'service', 'today');
}

function makeTechnicianWorkOrder(array $fixture, array $attributes = []): WorkOrder
{
    return WorkOrder::factory()->forCustomer($fixture['customer'], $fixture['site'])->create(array_merge([
        'organization_id' => $fixture['organization']->id,
        'service_id' => $fixture['service']->id,
        'created_by' => $fixture['dispatcher']->id,
        'number' => 'WO-TECH-'.fake()->unique()->numerify('######'),
        'status' => WorkOrderStatus::Scheduled,
        'priority' => WorkOrderPriority::Normal,
        'scheduled_start' => $fixture['today']->setTime(9, 0),
        'scheduled_end' => $fixture['today']->setTime(11, 0),
    ], $attributes));
}

function assignTechnician(WorkOrder $workOrder, User $technician): void
{
    $workOrder->assignments()->create(['user_id' => $technician->id, 'is_primary' => true, 'assigned_at' => now()]);
}

it('limits technician navigation and queries to assigned work orders', function () {
    $fixture = makeTechnicianExperienceFixture();
    $own = makeTechnicianWorkOrder($fixture, ['number' => 'WO-OWN-000001']);
    assignTechnician($own, $fixture['technician']);
    $other = makeTechnicianWorkOrder($fixture, ['number' => 'WO-OTHER-000001']);
    assignTechnician($other, $fixture['otherTechnician']);

    $this->actingAs($fixture['technician'])->get(route('technician.today'))->assertOk()->assertSee($own->number)->assertDontSee($other->number);
    $this->actingAs($fixture['technician'])->get(route('technician.tasks', ['tab' => 'upcoming']))->assertOk()->assertSee($own->number)->assertDontSee($other->number);
    $this->actingAs($fixture['technician'])->get(route('technician.work-orders.show', $other))->assertForbidden();
    $this->actingAs($fixture['dispatcher'])->get(route('technician.today'))->assertForbidden();
});

it('runs contextual technician status actions and writes history', function () {
    $fixture = makeTechnicianExperienceFixture();
    $workOrder = makeTechnicianWorkOrder($fixture);
    assignTechnician($workOrder, $fixture['technician']);

    foreach ([WorkOrderStatus::Dispatched, WorkOrderStatus::EnRoute, WorkOrderStatus::InProgress] as $status) {
        $this->actingAs($fixture['technician'])
            ->post(route('technician.work-orders.transition', $workOrder), ['status' => $status->value])
            ->assertRedirect();
    }

    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::InProgress)
        ->and($workOrder->statusHistories()->count())->toBe(3);
});

it('renders and saves all MVP checklist input types', function () {
    $fixture = makeTechnicianExperienceFixture();
    $workOrder = makeTechnicianWorkOrder($fixture, ['status' => WorkOrderStatus::InProgress]);
    assignTechnician($workOrder, $fixture['technician']);
    $items = [
        WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'sort_order' => 1, 'input_type' => ChecklistInputType::Checkbox]),
        WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'sort_order' => 2, 'input_type' => ChecklistInputType::Number]),
        WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'sort_order' => 3, 'input_type' => ChecklistInputType::Text]),
        WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'sort_order' => 4, 'input_type' => ChecklistInputType::Choice, 'options' => ['Baik', 'Perlu tindakan']]),
    ];

    $this->actingAs($fixture['technician'])->get(route('technician.work-orders.show', $workOrder))->assertOk()->assertSee('Checklist pekerjaan')->assertSee('Perlu tindakan');
    $values = [true, '18.5', 'Tekanan normal', 'Baik'];
    foreach ($items as $index => $item) {
        $this->actingAs($fixture['technician'])
            ->patch(route('technician.work-orders.checklist.update', [$workOrder, $item]), ['value' => $values[$index]])
            ->assertRedirect();
    }

    expect($workOrder->fresh()->checklistItems()->whereNotNull('value')->count())->toBe(4);
});

it('enforces one active timer per technician and allows stop', function () {
    $fixture = makeTechnicianExperienceFixture();
    $first = makeTechnicianWorkOrder($fixture, ['status' => WorkOrderStatus::InProgress, 'number' => 'WO-TIMER-000001']);
    $second = makeTechnicianWorkOrder($fixture, ['status' => WorkOrderStatus::InProgress, 'number' => 'WO-TIMER-000002']);
    assignTechnician($first, $fixture['technician']);
    assignTechnician($second, $fixture['technician']);

    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.time.start', $first))->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.time.start', $second))->assertSessionHasErrors('time');
    $timeLog = $first->timeLogs()->firstOrFail();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.time.stop', [$first, $timeLog]))->assertRedirect();

    expect($timeLog->fresh()->ended_at)->not->toBeNull();
});

it('uploads private photos and records technician notes and materials', function () {
    Storage::fake('local');
    $fixture = makeTechnicianExperienceFixture();
    $workOrder = makeTechnicianWorkOrder($fixture, ['status' => WorkOrderStatus::InProgress]);
    assignTechnician($workOrder, $fixture['technician']);

    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.photos.store', $workOrder), [
        'file' => UploadedFile::fake()->image('after.jpg'),
        'category' => 'after',
        'is_required' => '1',
    ])->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.notes.store', $workOrder), ['body' => 'Unit sudah diuji.', 'visibility' => 'internal'])->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.materials.store', $workOrder), ['description' => 'Filter AC', 'quantity' => '2', 'unit' => 'pcs', 'unit_price' => '125000'])->assertRedirect();

    $attachment = $workOrder->attachments()->firstOrFail();
    Storage::disk('local')->assertExists($attachment->path);
    expect($workOrder->notes()->count())->toBe(1)
        ->and($workOrder->materialUsages()->firstOrFail()->total)->toBe(250000);
});

it('blocks completion until photo, checklist, note, timer, and signature requirements are met', function () {
    Storage::fake('local');
    $fixture = makeTechnicianExperienceFixture(['signature_required' => true]);
    $workOrder = makeTechnicianWorkOrder($fixture, ['status' => WorkOrderStatus::InProgress]);
    assignTechnician($workOrder, $fixture['technician']);
    $item = WorkOrderChecklistItem::factory()->create(['work_order_id' => $workOrder->id, 'input_type' => ChecklistInputType::Checkbox, 'is_required' => true, 'photo_required' => true]);

    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.complete', $workOrder))->assertSessionHasErrors('completion');
    $this->actingAs($fixture['technician'])->patch(route('technician.work-orders.checklist.update', [$workOrder, $item]), ['value' => true])->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.notes.store', $workOrder), ['body' => 'Selesai diuji bersama pelanggan.', 'visibility' => 'customer'])->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.photos.store', $workOrder), ['file' => UploadedFile::fake()->image('evidence.jpg'), 'category' => 'evidence'])->assertRedirect();
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.signature.store', $workOrder), ['signer_name' => 'Fajar Pratama', 'signature_data' => 'data:image/png;base64,'.base64_encode('fake-png'), 'consent' => '1'])->assertRedirect();
    $timeLog = TimeLog::factory()->active()->create(['work_order_id' => $workOrder->id, 'user_id' => $fixture['technician']->id]);
    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.time.stop', [$workOrder, $timeLog]))->assertRedirect();

    $this->actingAs($fixture['technician'])->post(route('technician.work-orders.complete', $workOrder))->assertRedirect(route('technician.work-orders.success', $workOrder));
    expect($workOrder->fresh()->status)->toBe(WorkOrderStatus::Completed)->and($workOrder->signature()->exists())->toBeTrue();
});
