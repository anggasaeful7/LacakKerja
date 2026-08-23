<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OperationsDashboardQuery
{
    /** @var array<int, WorkOrderStatus> */
    private const ACTIVE_STATUSES = [
        WorkOrderStatus::Draft,
        WorkOrderStatus::Scheduled,
        WorkOrderStatus::Dispatched,
        WorkOrderStatus::EnRoute,
        WorkOrderStatus::InProgress,
        WorkOrderStatus::OnHold,
    ];

    public function __construct(
        private readonly OperationsDashboardCache $cache,
    ) {}

    /**
     * @return array{today: CarbonImmutable, now: CarbonImmutable, can_view_billing: bool, kpis: array<string, int>, status_breakdown: array<int, array{value: string, label: string, count: int, percent: int, tone: string}>, completion_trend: array<int, array{date: string, label: string, count: int}>, invoice_summary: array<string, int>, attention: Collection<int, WorkOrder>, technicians: Collection<int, array{user: User, count: int<0, max>, items: Collection<array-key, mixed>}>}
     */
    public function dashboard(Organization $organization, User $user): array
    {
        $today = CarbonImmutable::now($organization->timezone);
        $membership = $user->membershipFor($organization);
        $technicianId = $membership?->role === OrganizationRole::Technician ? $user->id : null;

        $aggregate = $this->cache->remember($organization->id, $today->toDateString(), fn (): array => $this->aggregates($organization, $today, $technicianId));

        return [
            'today' => $today,
            'now' => $today,
            'can_view_billing' => $membership?->role->canManageMasterData() ?? false,
            'kpis' => $aggregate['kpis'],
            'status_breakdown' => $aggregate['status_breakdown'],
            'completion_trend' => $aggregate['completion_trend'],
            'invoice_summary' => $aggregate['invoice_summary'],
            'attention' => $this->attention($organization, $today, $technicianId),
            'technicians' => $this->technicianTimeline($organization, $today, $technicianId),
        ];
    }

    /** @return array{today: CarbonImmutable, now: CarbonImmutable, kpis: array<string, int>, status_breakdown: array<int, array{value: string, label: string, count: int, percent: int, tone: string}>, completion_trend: array<int, array{date: string, label: string, count: int}>, invoice_summary: array<string, int>} */
    public function dashboardAggregates(Organization $organization, CarbonImmutable $today, ?int $technicianId = null): array
    {
        $aggregate = $this->aggregates($organization, $today, $technicianId);

        return [
            'today' => $today,
            'now' => $today,
            'kpis' => $aggregate['kpis'],
            'status_breakdown' => $aggregate['status_breakdown'],
            'completion_trend' => $aggregate['completion_trend'],
            'invoice_summary' => $aggregate['invoice_summary'],
        ];
    }

    /** @return array{today: CarbonImmutable, now: CarbonImmutable, kpis: array<string, int>, status_breakdown: array<int, array{value: string, label: string, count: int, percent: int, tone: string}>, completion_trend: array<int, array{date: string, label: string, count: int}>, invoice_summary: array<string, int>} */
    private function aggregates(Organization $organization, CarbonImmutable $today, ?int $technicianId): array
    {
        $start = $today->startOfDay();
        $end = $today->endOfDay();
        $now = $today;
        $riskUntil = $now->addHours(4);
        $activeValues = array_map(static fn (WorkOrderStatus $status): string => $status->value, self::ACTIVE_STATUSES);
        $base = $this->workOrderQuery($organization, $technicianId);

        $todayCount = (clone $base)->whereBetween('scheduled_start', [$start, $end])->count();
        $activeCount = (clone $base)->whereIn('status', $activeValues)->count();
        $completedToday = (clone $base)->where('status', WorkOrderStatus::Completed->value)->whereBetween('completed_at', [$start, $end])->count();
        $overdue = (clone $base)->whereIn('status', $activeValues)->whereNotNull('sla_due_at')->where('sla_due_at', '<', $now)->count();
        $slaRisk = (clone $base)->whereIn('status', $activeValues)->whereNotNull('sla_due_at')->where('sla_due_at', '<=', $riskUntil)->count();
        $unassigned = (clone $base)->whereIn('status', $activeValues)->whereDoesntHave('assignments', fn (Builder $query): Builder => $query->where('is_primary', true))->count();

        $statusRows = (clone $base)
            ->whereBetween('scheduled_start', [$start, $end])
            ->selectRaw('status, COUNT(*) as aggregate_count')
            ->groupBy('status')
            ->pluck('aggregate_count', 'status');
        $statusTotal = (int) $statusRows->sum();
        $statusBreakdown = collect(WorkOrderStatus::cases())
            ->map(fn (WorkOrderStatus $status): array => [
                'value' => $status->value,
                'label' => $status->label(),
                'count' => (int) ($statusRows[$status->value] ?? 0),
                'percent' => $statusTotal > 0 ? (int) round(((int) ($statusRows[$status->value] ?? 0) / $statusTotal) * 100) : 0,
                'tone' => $this->statusTone($status),
            ])
            ->filter(static fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();

        $trendFrom = $start->subDays(6);
        $trendRows = (clone $base)
            ->where('status', WorkOrderStatus::Completed->value)
            ->whereBetween('completed_at', [$trendFrom, $end])
            ->selectRaw('DATE(completed_at) as completion_date, COUNT(*) as aggregate_count')
            ->groupBy('completion_date')
            ->pluck('aggregate_count', 'completion_date');
        $completionTrend = collect(range(0, 6))->map(function (int $offset) use ($trendFrom, $trendRows, $today): array {
            $date = CarbonImmutable::parse($trendFrom->toDateString(), $today->getTimezone())->addDays($offset);
            $key = $date->toDateString();

            return ['date' => $key, 'label' => ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'][(int) date('w', (int) strtotime($key))], 'count' => (int) ($trendRows[$key] ?? 0)];
        })->all();

        $invoiceSummary = $this->invoiceSummary($organization, $today, $technicianId);

        return [
            'today' => $today,
            'now' => $now,
            'kpis' => [
                'today' => $todayCount,
                'active' => $activeCount,
                'completed' => $completedToday,
                'sla_risk' => $slaRisk,
                'unassigned' => $unassigned,
                'overdue' => $overdue,
            ],
            'status_breakdown' => $statusBreakdown,
            'completion_trend' => $completionTrend,
            'invoice_summary' => $invoiceSummary,
        ];
    }

    /** @return Collection<int, WorkOrder> */
    private function attention(Organization $organization, CarbonImmutable $today, ?int $technicianId): Collection
    {
        $activeValues = array_map(static fn (WorkOrderStatus $status): string => $status->value, self::ACTIVE_STATUSES);

        return $this->workOrderQuery($organization, $technicianId)
            ->with([
                'customer:id,organization_id,name',
                'site:id,organization_id,name,city',
                'primaryAssignment.user:id,name',
            ])
            ->whereIn('status', $activeValues)
            ->where(function (Builder $query) use ($today): void {
                $query
                    ->where('priority', WorkOrderPriority::Urgent->value)
                    ->orWhere('priority', WorkOrderPriority::High->value)
                    ->orWhere(function (Builder $sla) use ($today): void {
                        $sla->whereNotNull('sla_due_at')->where('sla_due_at', '<=', $today->addHours(4));
                    })
                    ->orWhereDoesntHave('assignments', fn (Builder $assignment): Builder => $assignment->where('is_primary', true));
            })
            ->orderByRaw("CASE WHEN sla_due_at IS NOT NULL AND sla_due_at < CURRENT_TIMESTAMP THEN 0 WHEN priority = 'urgent' THEN 1 WHEN priority = 'high' THEN 2 ELSE 3 END")
            ->orderBy('scheduled_start')
            ->limit(6)
            ->get();
    }

    /** @return Collection<int, array{user: User, count: int<0, max>, items: Collection<array-key, mixed>}> */
    private function technicianTimeline(Organization $organization, CarbonImmutable $today, ?int $technicianId): Collection
    {
        $memberships = Membership::query()
            ->forOrganization($organization)
            ->where('status', MembershipStatus::Active->value)
            ->where('role', OrganizationRole::Technician->value)
            ->when($technicianId !== null, fn (Builder $query): Builder => $query->where('user_id', $technicianId))
            ->with('user:id,name')
            ->orderBy('id')
            ->get();

        $workOrders = $this->workOrderQuery($organization, $technicianId)
            ->with(['customer:id,organization_id,name', 'primaryAssignment.user:id,name'])
            ->whereBetween('scheduled_start', [$today->startOfDay(), $today->endOfDay()])
            ->whereHas('assignments', fn (Builder $query): Builder => $query->where('is_primary', true))
            ->orderBy('scheduled_start')
            ->get()
            ->groupBy(fn (WorkOrder $workOrder): int => (int) $workOrder->primaryAssignment?->user_id);

        return $memberships->map(function (Membership $membership) use ($workOrders): array {
            $items = $workOrders->get($membership->user_id, collect());

            return [
                'user' => $membership->user,
                'count' => $items->count(),
                'items' => $items->take(3),
            ];
        });
    }

    /** @return array<string, int> */
    private function invoiceSummary(Organization $organization, CarbonImmutable $today, ?int $technicianId): array
    {
        if ($technicianId !== null) {
            return ['outstanding' => 0, 'overdue' => 0, 'overdue_count' => 0, 'paid_this_month' => 0];
        }

        $openStatuses = [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value, InvoiceStatus::Overdue->value];
        $open = Invoice::query()->forOrganization($organization)->whereIn('status', $openStatuses)->where('amount_due', '>', 0);

        return [
            'outstanding' => (int) (clone $open)->sum('amount_due'),
            'overdue' => (int) (clone $open)->where(function (Builder $query) use ($today): void {
                $query->where('status', InvoiceStatus::Overdue->value)
                    ->orWhere(function (Builder $issued) use ($today): void {
                        $issued->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value])
                            ->whereNotNull('due_date')
                            ->whereDate('due_date', '<', $today->toDateString());
                    });
            })->sum('amount_due'),
            'overdue_count' => (int) (clone $open)->where(function (Builder $query) use ($today): void {
                $query->where('status', InvoiceStatus::Overdue->value)
                    ->orWhere(function (Builder $issued) use ($today): void {
                        $issued->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value])
                            ->whereNotNull('due_date')
                            ->whereDate('due_date', '<', $today->toDateString());
                    });
            })->count(),
            'paid_this_month' => (int) $organization->invoices()->where('status', InvoiceStatus::Paid->value)->whereBetween('updated_at', [$today->startOfMonth(), $today->endOfMonth()])->sum('paid_amount'),
        ];
    }

    /** @return Builder<WorkOrder> */
    private function workOrderQuery(Organization $organization, ?int $technicianId = null): Builder
    {
        return WorkOrder::query()
            ->forOrganization($organization)
            ->when($technicianId !== null, fn (Builder $query): Builder => $query->whereHas('assignments', fn (Builder $assignment): Builder => $assignment->where('user_id', $technicianId)));
    }

    private function statusTone(WorkOrderStatus $status): string
    {
        return match ($status) {
            WorkOrderStatus::Completed => 'success',
            WorkOrderStatus::OnHold, WorkOrderStatus::Cancelled => 'danger',
            WorkOrderStatus::InProgress, WorkOrderStatus::EnRoute => 'info',
            default => 'neutral',
        };
    }
}
