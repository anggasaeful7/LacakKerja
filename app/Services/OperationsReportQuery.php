<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\WorkOrderStatus;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\WorkOrder;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

class OperationsReportQuery
{
    /**
     * @param  array{from: CarbonImmutable, to: CarbonImmutable, status?: string|null, priority?: string|null, technician_id?: int|null}  $filters
     * @return Builder<WorkOrder>
     */
    public function workOrders(Organization $organization, array $filters, ?int $scopedTechnicianId = null): Builder
    {
        return WorkOrder::query()
            ->forOrganization($organization)
            ->with(['customer:id,organization_id,name', 'site:id,organization_id,name,city', 'primaryAssignment.user:id,name'])
            ->whereBetween('created_at', [$filters['from'], $filters['to']])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status): Builder => $query->where('status', $status))
            ->when($filters['priority'] ?? null, fn (Builder $query, string $priority): Builder => $query->where('priority', $priority))
            ->when($filters['technician_id'] ?? $scopedTechnicianId, function (Builder $query, ?int $technicianId): Builder {
                return $query->whereHas('assignments', fn (Builder $assignment): Builder => $assignment->where('user_id', $technicianId));
            });
    }

    /**
     * @param  array{from: CarbonImmutable, to: CarbonImmutable, status?: string|null, priority?: string|null, technician_id?: int|null}  $filters
     * @return array{total: int, completed: int, overdue: int, estimated_total: int}
     */
    public function workOrderSummary(Organization $organization, array $filters, ?int $scopedTechnicianId = null): array
    {
        $query = $this->workOrders($organization, $filters, $scopedTechnicianId);

        return [
            'total' => (clone $query)->count(),
            'completed' => (clone $query)->where('status', WorkOrderStatus::Completed->value)->count(),
            'overdue' => (clone $query)->whereIn('status', $this->activeStatusValues())->whereNotNull('sla_due_at')->where('sla_due_at', '<', now())->count(),
            'estimated_total' => (int) (clone $query)->sum('estimated_total'),
        ];
    }

    /**
     * @param  array{from: CarbonImmutable, to: CarbonImmutable, status?: string|null}  $filters
     * @return Builder<Invoice>
     */
    public function invoices(Organization $organization, array $filters): Builder
    {
        return Invoice::query()
            ->forOrganization($organization)
            ->with(['customer:id,organization_id,name', 'workOrder:id,organization_id,number'])
            ->whereBetween('created_at', [$filters['from'], $filters['to']])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status): Builder => $query->where('status', $status));
    }

    /**
     * @param  array{from: CarbonImmutable, to: CarbonImmutable, status?: string|null}  $filters
     * @return array{invoiced: int, collected: int, outstanding: int, overdue: int}
     */
    public function invoiceSummary(Organization $organization, array $filters): array
    {
        $query = $this->invoices($organization, $filters);
        $openStatuses = [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value, InvoiceStatus::Overdue->value];

        return [
            'invoiced' => (int) (clone $query)->whereNotIn('status', [InvoiceStatus::Draft->value, InvoiceStatus::Void->value])->sum('total_amount'),
            'collected' => (int) (clone $query)->sum('paid_amount'),
            'outstanding' => (int) (clone $query)->whereIn('status', $openStatuses)->sum('amount_due'),
            'overdue' => (int) (clone $query)->where(function (Builder $overdue) use ($openStatuses): void {
                $overdue->where('status', InvoiceStatus::Overdue->value)
                    ->orWhere(function (Builder $dated) use ($openStatuses): void {
                        $dated->whereIn('status', array_diff($openStatuses, [InvoiceStatus::Overdue->value]))
                            ->whereNotNull('due_date')
                            ->whereDate('due_date', '<', now()->toDateString());
                    });
            })->sum('amount_due'),
        ];
    }

    /** @return array<int, string> */
    private function activeStatusValues(): array
    {
        return array_map(static fn (WorkOrderStatus $status): string => $status->value, [
            WorkOrderStatus::Draft,
            WorkOrderStatus::Scheduled,
            WorkOrderStatus::Dispatched,
            WorkOrderStatus::EnRoute,
            WorkOrderStatus::InProgress,
            WorkOrderStatus::OnHold,
        ]);
    }
}
