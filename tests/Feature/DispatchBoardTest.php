<?php

use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\TechnicianProfile;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

function makeDispatchFixture(): array
{
    $organization = Organization::factory()->create(['timezone' => 'Asia/Jakarta']);
    $dispatcher = User::factory()->create(['current_organization_id' => $organization->id]);
    $owner = User::factory()->create(['current_organization_id' => $organization->id]);
    $technician = User::factory()->create();
    $backupTechnician = User::factory()->create();

    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $backupTechnician->id, 'role' => OrganizationRole::Technician]);
    TechnicianProfile::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id]);
    TechnicianProfile::factory()->create(['organization_id' => $organization->id, 'user_id' => $backupTechnician->id]);

    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id, 'city' => 'Jakarta Selatan']);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $date = CarbonImmutable::now($organization->timezone)->addDay()->startOfDay();

    return compact('organization', 'dispatcher', 'owner', 'technician', 'backupTechnician', 'customer', 'site', 'service', 'date');
}

function makeDispatchWorkOrder(array $fixture, array $attributes = []): WorkOrder
{
    return WorkOrder::factory()->forCustomer($fixture['customer'], $fixture['site'])->create(array_merge([
        'organization_id' => $fixture['organization']->id,
        'service_id' => $fixture['service']->id,
        'created_by' => $fixture['dispatcher']->id,
        'status' => WorkOrderStatus::Scheduled,
        'priority' => WorkOrderPriority::Normal,
        'scheduled_start' => $fixture['date']->setTime(9, 0),
        'scheduled_end' => $fixture['date']->setTime(11, 0),
    ], $attributes));
}

it('renders the dispatch board with an unassigned lane and accessible list', function () {
    $fixture = makeDispatchFixture();
    $assigned = makeDispatchWorkOrder($fixture, ['number' => 'WO-DISPATCH-001']);
    $assigned->assignments()->create(['user_id' => $fixture['technician']->id, 'is_primary' => true, 'assigned_at' => now()]);
    $unassigned = makeDispatchWorkOrder($fixture, ['number' => 'WO-DISPATCH-002', 'status' => WorkOrderStatus::Draft, 'scheduled_start' => null, 'scheduled_end' => null]);

    $response = $this->actingAs($fixture['dispatcher'])->get(route('dispatch.index', ['date' => $fixture['date']->toDateString()]));

    $response->assertOk()
        ->assertSee('Belum Ditugaskan')
        ->assertSee($assigned->number)
        ->assertSee($unassigned->number)
        ->assertSee('Daftar aksesibel');
});

it('detects overlapping schedules with a text warning', function () {
    $fixture = makeDispatchFixture();
    $first = makeDispatchWorkOrder($fixture, ['number' => 'WO-OVERLAP-001']);
    $second = makeDispatchWorkOrder($fixture, ['number' => 'WO-OVERLAP-002', 'scheduled_start' => $fixture['date']->setTime(10, 0), 'scheduled_end' => $fixture['date']->setTime(12, 0)]);
    foreach ([$first, $second] as $workOrder) {
        $workOrder->assignments()->create(['user_id' => $fixture['technician']->id, 'is_primary' => true, 'assigned_at' => now()]);
    }

    $this->actingAs($fixture['dispatcher'])
        ->get(route('dispatch.index', ['date' => $fixture['date']->toDateString()]))
        ->assertOk()
        ->assertSee('bentrok');
});

it('assigns and schedules a draft work order only after explicit confirmation', function () {
    $fixture = makeDispatchFixture();
    $workOrder = makeDispatchWorkOrder($fixture, ['number' => 'WO-ASSIGN-001', 'status' => WorkOrderStatus::Draft, 'scheduled_start' => null, 'scheduled_end' => null]);
    $start = $fixture['date']->setTime(13, 0);
    $end = $fixture['date']->setTime(15, 0);

    $this->actingAs($fixture['dispatcher'])
        ->post(route('dispatch.schedule', $workOrder), [
            'technician_id' => $fixture['backupTechnician']->id,
            'scheduled_start' => $start->format('Y-m-d\TH:i'),
            'scheduled_end' => $end->format('Y-m-d\TH:i'),
        ])
        ->assertSessionHasErrors('confirmed');

    $this->actingAs($fixture['dispatcher'])
        ->post(route('dispatch.schedule', $workOrder), [
            'technician_id' => $fixture['backupTechnician']->id,
            'scheduled_start' => $start->format('Y-m-d\TH:i'),
            'scheduled_end' => $end->format('Y-m-d\TH:i'),
            'confirmed' => '1',
            'return_date' => $fixture['date']->toDateString(),
            'return_view' => 'day',
            'return_q' => 'assign',
        ])
        ->assertRedirect(route('dispatch.index', ['date' => $fixture['date']->toDateString(), 'view' => 'day', 'technician_id' => $fixture['backupTechnician']->id, 'q' => 'assign']))
        ->assertSessionHas('status');

    $fresh = $workOrder->fresh();
    expect($fresh->status)->toBe(WorkOrderStatus::Scheduled)
        ->and($fresh->scheduled_start?->format('H:i'))->toBe('13:00')
        ->and($fresh->primaryAssignment?->user_id)->toBe($fixture['backupTechnician']->id);
});

it('rejects cross-tenant or technician assignment mutations', function () {
    $fixture = makeDispatchFixture();
    $workOrder = makeDispatchWorkOrder($fixture, ['status' => WorkOrderStatus::Draft, 'scheduled_start' => null, 'scheduled_end' => null]);
    $other = makeDispatchFixture();

    $this->actingAs($fixture['dispatcher'])
        ->post(route('dispatch.schedule', $workOrder), [
            'technician_id' => $other['technician']->id,
            'scheduled_start' => $fixture['date']->setTime(9, 0)->format('Y-m-d\TH:i'),
            'scheduled_end' => $fixture['date']->setTime(11, 0)->format('Y-m-d\TH:i'),
            'confirmed' => '1',
        ])
        ->assertSessionHasErrors('technician_id');

    $this->actingAs($fixture['technician'])
        ->post(route('dispatch.schedule', $workOrder), ['confirmed' => '1'])
        ->assertForbidden();
});

it('keeps agenda query count bounded for a larger schedule seed', function () {
    $fixture = makeDispatchFixture();
    for ($index = 0; $index < 24; $index++) {
        $workOrder = makeDispatchWorkOrder($fixture, ['number' => 'WO-PERF-'.str_pad((string) $index, 3, '0', STR_PAD_LEFT), 'scheduled_start' => $fixture['date']->setTime(6 + ($index % 10), 0), 'scheduled_end' => $fixture['date']->setTime(7 + ($index % 10), 0)]);
        $workOrder->assignments()->create(['user_id' => ($index % 2 === 0 ? $fixture['technician']->id : $fixture['backupTechnician']->id), 'is_primary' => true, 'assigned_at' => now()]);
    }

    $queries = 0;
    DB::listen(function () use (&$queries): void {
        $queries++;
    });
    $this->actingAs($fixture['dispatcher'])->get(route('dispatch.index', ['date' => $fixture['date']->toDateString()]));

    expect($queries)->toBeLessThan(30);
});

it('updates a technician profile with skills and availability', function () {
    $fixture = makeDispatchFixture();

    $this->actingAs($fixture['dispatcher'])
        ->patch(route('dispatch.technicians.update', $fixture['technician']), [
            'employee_code' => 'TECH-900',
            'phone' => '+62 811 9999 0000',
            'skills' => 'HVAC, Electrical',
            'display_color' => '#123456',
            'availability' => ['mon' => ['start' => '07:30', 'end' => '16:30']],
            'return_date' => $fixture['date']->toDateString(),
        ])
        ->assertRedirect(route('dispatch.index', ['date' => $fixture['date']->toDateString()]));

    $profile = TechnicianProfile::query()->where('user_id', $fixture['technician']->id)->firstOrFail();
    expect($profile->employee_code)->toBe('TECH-900')
        ->and($profile->skills)->toBe(['HVAC', 'Electrical'])
        ->and($profile->availabilityFor('mon'))->toBe(['start' => '07:30', 'end' => '16:30']);
});
