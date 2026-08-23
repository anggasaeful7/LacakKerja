<?php

namespace Database\Factories;

use App\Enums\WorkOrderStatus;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderStatusHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WorkOrderStatusHistory> */
class WorkOrderStatusHistoryFactory extends Factory
{
    protected $model = WorkOrderStatusHistory::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'changed_by' => User::factory(),
            'from_status' => null,
            'to_status' => WorkOrderStatus::Draft,
            'reason' => null,
            'created_at' => now(),
        ];
    }
}
