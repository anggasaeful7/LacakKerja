<?php

namespace Database\Factories;

use App\Enums\ChecklistInputType;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WorkOrderChecklistItem> */
class WorkOrderChecklistItemFactory extends Factory
{
    protected $model = WorkOrderChecklistItem::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'completed_by' => null,
            'sort_order' => fake()->numberBetween(1, 10),
            'label' => fake()->sentence(4),
            'input_type' => ChecklistInputType::Checkbox,
            'is_required' => true,
            'photo_required' => false,
            'options' => [],
            'value' => null,
            'completed_at' => null,
        ];
    }

    public function completed(User $user): static
    {
        return $this->state(fn () => [
            'completed_by' => $user->id,
            'value' => ['value' => true],
            'completed_at' => now(),
        ]);
    }
}
