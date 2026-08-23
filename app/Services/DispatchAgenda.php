<?php

namespace App\Services;

use App\Enums\WorkOrderStatus;
use App\Models\Organization;
use App\Models\WorkOrder;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DispatchAgenda
{
    /**
     * @param  array{technician_id?: int|null, status?: string|null, priority?: string|null, area?: string|null, q?: string|null}  $filters
     * @return Collection<int, WorkOrder>
     */
    public function forRange(Organization $organization, CarbonImmutable $from, CarbonImmutable $to, array $filters = []): Collection
    {
        $query = WorkOrder::query()
            ->forOrganization($organization)
            ->with([
                'customer:id,organization_id,name,phone',
                'site:id,organization_id,customer_id,name,city,province,address_line1',
                'service:id,organization_id,name',
                'primaryAssignment.user:id,name,email',
            ])
            ->where(function (Builder $schedule) use ($from, $to): void {
                $schedule
                    ->where(function (Builder $overlap) use ($from, $to): void {
                        $overlap->whereNotNull('scheduled_start')
                            ->whereNotNull('scheduled_end')
                            ->where('scheduled_start', '<', $to)
                            ->where('scheduled_end', '>', $from);
                    })
                    ->orWhereNull('scheduled_start');
            });

        if (filled($filters['technician_id'] ?? null)) {
            $query->whereHas('assignments', fn (Builder $assignment): Builder => $assignment->where('user_id', $filters['technician_id'])->where('is_primary', true));
        }

        if (filled($filters['status'] ?? null)) {
            $query->where('status', $filters['status']);
        }

        if (filled($filters['priority'] ?? null)) {
            $query->where('priority', $filters['priority']);
        }

        if (filled($filters['area'] ?? null)) {
            $area = trim((string) $filters['area']);
            $query->whereHas('site', function (Builder $site) use ($area): void {
                $site->where('city', 'like', "%{$area}%")
                    ->orWhere('province', 'like', "%{$area}%");
            });
        }

        if (filled($filters['q'] ?? null)) {
            $query->search(trim((string) $filters['q']));
        }

        $workOrders = $query
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'normal' THEN 3 ELSE 4 END")
            ->orderByRaw('CASE WHEN scheduled_start IS NULL THEN 0 ELSE 1 END')
            ->orderBy('scheduled_start')
            ->orderBy('number')
            ->get();

        $this->annotateConflicts($workOrders);

        return $workOrders;
    }

    /** @param Collection<int, WorkOrder> $workOrders */
    private function annotateConflicts(Collection $workOrders): void
    {
        $scheduled = $workOrders->filter(fn (WorkOrder $workOrder): bool => $workOrder->scheduled_start !== null
            && $workOrder->scheduled_end !== null
            && $workOrder->primaryAssignment?->is_primary === true
            && ! in_array($workOrder->status, [WorkOrderStatus::Completed, WorkOrderStatus::Cancelled], true),
        );

        foreach ($workOrders as $workOrder) {
            $count = 0;
            if ($workOrder->scheduled_start !== null && $workOrder->scheduled_end !== null && $workOrder->primaryAssignment?->user_id !== null) {
                $count = $scheduled
                    ->reject(fn (WorkOrder $candidate): bool => $candidate->is($workOrder))
                    ->filter(fn (WorkOrder $candidate): bool => data_get($candidate->primaryAssignment, 'user_id') === data_get($workOrder->primaryAssignment, 'user_id')
                        && $candidate->scheduled_start?->lessThan($workOrder->scheduled_end)
                        && $candidate->scheduled_end?->greaterThan($workOrder->scheduled_start),
                    )
                    ->count();
            }

            $workOrder->setAttribute('schedule_conflict_count', $count);
        }
    }
}
