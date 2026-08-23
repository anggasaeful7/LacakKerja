<?php

use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignment;
use App\Services\OperationsDashboardQuery;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

function reportingFixture(): array
{
    $organization = Organization::factory()->create(['timezone' => 'Asia/Jakarta', 'currency' => 'IDR']);
    $owner = User::factory()->create(['current_organization_id' => $organization->id]);
    $technician = User::factory()->create(['current_organization_id' => $organization->id]);
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->create(['organization_id' => $organization->id, 'customer_id' => $customer->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $today = CarbonImmutable::now($organization->timezone);

    $overdue = WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'status' => WorkOrderStatus::InProgress,
        'priority' => WorkOrderPriority::Urgent,
        'scheduled_start' => $today->setTime(9, 0),
        'scheduled_end' => $today->setTime(10, 0),
        'sla_due_at' => $today->subHour(),
    ]);
    WorkOrderAssignment::factory()->create(['work_order_id' => $overdue->id, 'user_id' => $technician->id, 'is_primary' => true]);

    $unassigned = WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => $today->setTime(11, 0),
        'scheduled_end' => $today->setTime(12, 0),
        'sla_due_at' => $today->addHours(2),
    ]);

    WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'status' => WorkOrderStatus::Completed,
        'completed_at' => $today->setTime(8, 0),
        'scheduled_start' => $today->setTime(7, 0),
        'scheduled_end' => $today->setTime(8, 0),
    ]);

    $otherOrganization = Organization::factory()->create(['timezone' => 'Asia/Jakarta']);
    $otherCustomer = Customer::factory()->create(['organization_id' => $otherOrganization->id]);
    $otherSite = CustomerSite::factory()->create(['organization_id' => $otherOrganization->id, 'customer_id' => $otherCustomer->id]);
    WorkOrder::factory()->forCustomer($otherCustomer, $otherSite)->create(['organization_id' => $otherOrganization->id, 'title' => 'Tenant lain tidak boleh terlihat', 'scheduled_start' => $today]);

    return compact('organization', 'owner', 'technician', 'customer', 'site', 'service', 'today', 'overdue', 'unassigned');
}

it('renders deterministic KPI cards and isolates dashboard data per organization', function () {
    $fixture = reportingFixture();

    $response = $this->actingAs($fixture['owner'])->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Dashboard operasional')
        ->assertSee('Terjadwal hari ini')
        ->assertSee($fixture['overdue']->number)
        ->assertDontSee('Tenant lain tidak boleh terlihat');

    $dashboard = app(OperationsDashboardQuery::class)->dashboard($fixture['organization'], $fixture['owner']);

    expect($dashboard['kpis']['today'])->toBe(3)
        ->and($dashboard['kpis']['active'])->toBe(2)
        ->and($dashboard['kpis']['completed'])->toBe(1)
        ->and($dashboard['kpis']['overdue'])->toBe(1)
        ->and($dashboard['kpis']['unassigned'])->toBe(1);
});

it('scopes technician dashboard to assigned work orders and keeps billing hidden', function () {
    $fixture = reportingFixture();

    $response = $this->actingAs($fixture['technician'])->get(route('dashboard'));

    $response->assertOk()
        ->assertSee($fixture['overdue']->number)
        ->assertDontSee($fixture['unassigned']->number)
        ->assertDontSee('Receivables');
});

it('provides role-aware reports and CSV exports', function () {
    $fixture = reportingFixture();

    $this->actingAs($fixture['owner'])->get(route('reports.operations'))
        ->assertOk()
        ->assertSee('Laporan work order')
        ->assertSee($fixture['overdue']->number);

    $this->actingAs($fixture['owner'])->get(route('reports.revenue'))
        ->assertOk()
        ->assertSee('Revenue & receivables', false);

    $this->actingAs($fixture['owner'])->get(route('reports.operations.export'))
        ->assertOk()
        ->assertHeader('content-type', 'text/csv; charset=UTF-8')
        ->assertDownload();

    $this->actingAs($fixture['technician'])->get(route('reports.operations'))->assertForbidden();
    $this->actingAs($fixture['technician'])->get(route('reports.revenue'))->assertForbidden();
});

it('invalidates the short dashboard cache after a work order changes', function () {
    $fixture = reportingFixture();
    Cache::flush();
    $query = app(OperationsDashboardQuery::class);
    $first = $query->dashboard($fixture['organization'], $fixture['owner']);

    WorkOrder::factory()->forCustomer(
        Customer::query()->where('organization_id', $fixture['organization']->id)->firstOrFail(),
        CustomerSite::query()->where('organization_id', $fixture['organization']->id)->firstOrFail(),
    )->create([
        'organization_id' => $fixture['organization']->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => $fixture['today']->setTime(13, 0),
        'scheduled_end' => $fixture['today']->setTime(14, 0),
    ]);

    $second = $query->dashboard($fixture['organization'], $fixture['owner']);

    expect($first['kpis']['today'])->toBe(3)
        ->and($second['kpis']['today'])->toBe(4);
});

it('keeps the dashboard aggregate query count bounded for a seeded organization', function () {
    $fixture = reportingFixture();
    Cache::flush();
    WorkOrder::factory()->count(100)->forCustomer($fixture['customer'], $fixture['site'])->create([
        'organization_id' => $fixture['organization']->id,
        'service_id' => $fixture['service']->id,
        'created_by' => $fixture['owner']->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => $fixture['today']->setTime(15, 0),
        'scheduled_end' => $fixture['today']->setTime(16, 0),
    ]);

    DB::enableQueryLog();

    app(OperationsDashboardQuery::class)->dashboard($fixture['organization'], $fixture['owner']);

    expect(count(DB::getQueryLog()))->toBeLessThanOrEqual(28);
});
