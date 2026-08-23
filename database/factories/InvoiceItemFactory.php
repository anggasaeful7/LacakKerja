<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<InvoiceItem> */
class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition(): array
    {
        $unitPrice = fake()->numberBetween(100000, 1000000);

        return [
            'invoice_id' => Invoice::factory(),
            'service_id' => null,
            'description' => fake()->sentence(4),
            'quantity' => '1.000',
            'unit_price' => $unitPrice,
            'line_total' => $unitPrice,
        ];
    }
}
