<?php

namespace Database\Factories;

use App\Enums\ChecklistInputType;
use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ChecklistTemplateItem> */
class ChecklistTemplateItemFactory extends Factory
{
    protected $model = ChecklistTemplateItem::class;

    public function definition(): array
    {
        return [
            'checklist_template_id' => ChecklistTemplate::factory(),
            'position' => 1,
            'label' => fake()->sentence(4),
            'input_type' => ChecklistInputType::Checkbox,
            'is_required' => true,
            'photo_required' => false,
            'options' => null,
            'help_text' => null,
        ];
    }

    /** @param array<int, string> $options */
    public function choice(array $options = ['Baik', 'Perlu perhatian', 'Rusak']): static
    {
        return $this->state(fn () => [
            'input_type' => ChecklistInputType::Choice,
            'options' => $options,
        ]);
    }
}
