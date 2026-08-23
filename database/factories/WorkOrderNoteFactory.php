<?php

namespace Database\Factories;

use App\Enums\WorkOrderNoteVisibility;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WorkOrderNote> */
class WorkOrderNoteFactory extends Factory
{
    protected $model = WorkOrderNote::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'user_id' => User::factory(),
            'visibility' => WorkOrderNoteVisibility::Internal,
            'body' => fake()->paragraph(),
        ];
    }
}
