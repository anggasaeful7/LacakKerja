<?php

namespace Database\Factories;

use App\Enums\ChecklistStatus;
use App\Models\ChecklistTemplate;
use App\Models\Organization;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<ChecklistTemplate> */
class ChecklistTemplateFactory extends Factory
{
    protected $model = ChecklistTemplate::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Preventive AC Checklist', 'Safety Inspection', 'Commissioning Checklist']);

        return [
            'organization_id' => Organization::factory(),
            'service_id' => null,
            'template_key' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 9999),
            'name' => $name,
            'description' => fake()->sentence(),
            'version' => 1,
            'status' => ChecklistStatus::Draft,
            'is_current' => true,
            'published_at' => null,
            'snapshot' => null,
        ];
    }

    public function forService(Service $service): static
    {
        return $this->state(fn () => [
            'organization_id' => $service->organization_id,
            'service_id' => $service->id,
        ]);
    }
}
