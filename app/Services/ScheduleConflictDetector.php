<?php

namespace App\Services;

use App\Enums\WorkOrderStatus;
use App\Models\Organization;
use App\Models\WorkOrder;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class ScheduleConflictDetector
{
    /**
     * @return Collection<int, WorkOrder>
     */
    public function for(Organization $organization, int $technicianId, CarbonImmutable $start, CarbonImmutable $end, ?int $exceptWorkOrderId = null): Collection
    {
        return WorkOrder::query()
            ->forOrganization($organization)
            ->with(['customer:id,name', 'site:id,name,city', 'primaryAssignment.user:id,name'])
            ->when($exceptWorkOrderId !== null, fn ($query) => $query->whereKeyNot($exceptWorkOrderId))
            ->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
            ->whereNotNull('scheduled_start')
            ->whereNotNull('scheduled_end')
            ->where('scheduled_start', '<', $end)
            ->where('scheduled_end', '>', $start)
            ->whereHas('assignments', fn ($query) => $query->where('user_id', $technicianId)->where('is_primary', true))
            ->orderBy('scheduled_start')
            ->get();
    }
}
