<?php

namespace Database\Factories;

use App\Models\MaterialUsage;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MaterialUsage> */
class MaterialUsageFactory extends Factory
{
    protected $model = MaterialUsage::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(3, 1, 5);
        $unitPrice = fake()->numberBetween(10000, 500000);

        return [
            'work_order_id' => WorkOrder::factory(),
            'user_id' => User::factory(),
            'description' => fake()->randomElement(['Filter AC', 'Refrigerant R32', 'Kabel power']),
            'quantity' => $quantity,
            'unit' => 'pcs',
            'unit_price' => $unitPrice,
            'total' => (int) round($quantity * $unitPrice),
        ];
    }
}
