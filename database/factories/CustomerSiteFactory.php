<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CustomerSite> */
class CustomerSiteFactory extends Factory
{
    protected $model = CustomerSite::class;

    public function definition(): array
    {
        $customer = Customer::factory();

        return [
            'organization_id' => Organization::factory(),
            'customer_id' => $customer,
            'name' => 'Kantor Utama',
            'code' => fake()->unique()->bothify('SITE-###'),
            'contact_name' => fake()->name(),
            'contact_phone' => fake()->numerify('+62 8## #### ####'),
            'contact_email' => fake()->safeEmail(),
            'address_line1' => fake()->streetAddress(),
            'address_line2' => null,
            'city' => fake()->city(),
            'province' => 'DKI Jakarta',
            'postal_code' => fake()->postcode(),
            'latitude' => fake()->latitude(-6.4, -6.1),
            'longitude' => fake()->longitude(106.6, 107.0),
            'access_notes' => fake()->optional()->sentence(),
            'is_default' => true,
        ];
    }

    public function forCustomer(Customer $customer): static
    {
        return $this->state(fn () => [
            'organization_id' => $customer->organization_id,
            'customer_id' => $customer->id,
        ]);
    }
}
