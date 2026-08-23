<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WorkOrderAssignment> */
class WorkOrderAssignmentFactory extends Factory
{
    protected $model = WorkOrderAssignment::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'user_id' => User::factory(),
            'is_primary' => true,
            'assigned_at' => now(),
            'acknowledged_at' => null,
        ];
    }
}
