<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Invoice> */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $total = fake()->numberBetween(250000, 2500000);

        return [
            'organization_id' => Organization::factory(),
            'customer_id' => Customer::factory(),
            'work_order_id' => null,
            'revision_of_id' => null,
            'number' => 'INV-'.now()->format('Y').'-'.fake()->unique()->numerify('######'),
            'status' => InvoiceStatus::Draft,
            'currency' => 'IDR',
            'issued_at' => null,
            'due_date' => now()->addDays(14)->toDateString(),
            'subtotal' => $total,
            'discount_amount' => 0,
            'tax_rate' => '0.00',
            'tax_amount' => 0,
            'total_amount' => $total,
            'paid_amount' => 0,
            'amount_due' => $total,
            'notes' => null,
            'voided_at' => null,
            'void_reason' => null,
        ];
    }

    public function issued(): static
    {
        return $this->state(fn (): array => [
            'status' => InvoiceStatus::Issued,
            'issued_at' => now(),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => InvoiceStatus::Paid,
            'paid_amount' => $attributes['total_amount'],
            'amount_due' => 0,
        ]);
    }
}
