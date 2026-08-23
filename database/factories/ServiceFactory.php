<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Service> */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'service_code' => 'SVC-'.fake()->unique()->numerify('###'),
            'name' => fake()->randomElement(['Preventive Maintenance', 'Emergency Repair', 'Installation']),
            'description' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([60, 90, 120, 180]),
            'base_price' => fake()->randomFloat(2, 150000, 2500000),
            'is_active' => true,
        ];
    }
}
