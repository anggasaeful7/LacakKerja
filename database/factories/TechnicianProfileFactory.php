<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\TechnicianProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TechnicianProfile> */
class TechnicianProfileFactory extends Factory
{
    protected $model = TechnicianProfile::class;

    public function definition(): array
    {
        $days = ['mon', 'tue', 'wed', 'thu', 'fri'];

        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'employee_code' => 'TECH-'.fake()->unique()->numerify('####'),
            'phone' => fake()->phoneNumber(),
            'skills' => fake()->randomElements(['HVAC', 'Electrical', 'Plumbing', 'Generator'], fake()->numberBetween(1, 3)),
            'display_color' => fake()->randomElement(['#0284c7', '#7c3aed', '#059669', '#d97706']),
            'availability' => collect($days)->mapWithKeys(fn (string $day): array => [$day => ['start' => '08:00', 'end' => '17:00']])->all(),
        ];
    }
}
