<?php

namespace Database\Factories;

use App\Models\Signature;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Signature> */
class SignatureFactory extends Factory
{
    protected $model = Signature::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'signer_name' => fake()->name(),
            'path' => 'work-orders/'.fake()->uuid().'/signature.png',
            'consent_version' => 'v1',
            'signed_at' => now(),
        ];
    }
}
