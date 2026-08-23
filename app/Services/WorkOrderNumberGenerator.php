<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;

class WorkOrderNumberGenerator
{
    public function next(Organization $organization): string
    {
        return DB::transaction(function () use ($organization): string {
            Organization::query()
                ->whereKey($organization->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $year = now($organization->timezone)->format('Y');
            $prefix = 'WO-'.$year.'-';
            $lastNumber = WorkOrder::query()
                ->forOrganization($organization)
                ->where('number', 'like', $prefix.'%')
                ->orderByDesc('number')
                ->value('number');

            $sequence = $lastNumber !== null
                ? ((int) str($lastNumber)->after($prefix)->toString()) + 1
                : 1;

            return $prefix.str_pad((string) $sequence, 6, '0', STR_PAD_LEFT);
        });
    }
}
