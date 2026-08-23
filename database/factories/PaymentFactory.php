<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'invoice_id' => Invoice::factory(),
            'received_by' => User::factory(),
            'amount' => fake()->numberBetween(50000, 500000),
            'method' => PaymentMethod::BankTransfer,
            'reference' => fake()->optional()->bothify('PAY-########'),
            'paid_at' => now(),
            'notes' => null,
        ];
    }
}
