<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Customer> */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'customer_number' => 'CUS-'.fake()->unique()->numerify('######'),
            'name' => fake()->company(),
            'customer_type' => 'business',
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->numerify('+62 8## #### ####'),
            'tax_id' => fake()->optional()->numerify('##.###.###.#-###.###'),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function individual(): static
    {
        return $this->state(fn () => [
            'customer_type' => 'individual',
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);
    }
}
