<?php

namespace Database\Factories;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Asset> */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'customer_id' => Customer::factory(),
            'customer_site_id' => CustomerSite::factory(),
            'asset_identifier' => 'AST-'.fake()->unique()->numerify('######'),
            'qr_identifier' => (string) Str::uuid(),
            'name' => 'Unit AC Split '.fake()->numberBetween(1, 20),
            'category' => 'Air Conditioner',
            'brand' => fake()->randomElement(['Daikin', 'Panasonic', 'LG', 'Mitsubishi Electric']),
            'model' => fake()->bothify('FTKC-##?V'),
            'serial_number' => fake()->unique()->bothify('SN-########'),
            'status' => AssetStatus::Active,
            'installation_date' => fake()->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d'),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function forSite(CustomerSite $site): static
    {
        return $this->state(fn () => [
            'organization_id' => $site->organization_id,
            'customer_id' => $site->customer_id,
            'customer_site_id' => $site->id,
        ]);
    }
}
