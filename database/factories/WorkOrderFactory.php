<?php

namespace Database\Factories;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WorkOrder> */
class WorkOrderFactory extends Factory
{
    protected $model = WorkOrder::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'customer_id' => Customer::factory(),
            'customer_site_id' => CustomerSite::factory(),
            'asset_id' => null,
            'service_id' => Service::factory(),
            'created_by' => User::factory(),
            'number' => 'WO-'.now()->format('Y').'-'.fake()->unique()->numerify('######'),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'priority' => WorkOrderPriority::Normal,
            'status' => WorkOrderStatus::Draft,
            'scheduled_start' => null,
            'scheduled_end' => null,
            'sla_due_at' => null,
            'completed_at' => null,
            'estimated_total' => fake()->numberBetween(250000, 2500000),
            'lock_version' => 1,
        ];
    }

    public function forCustomer(Customer $customer, CustomerSite $site): static
    {
        return $this->state(fn () => [
            'organization_id' => $customer->organization_id,
            'customer_id' => $customer->id,
            'customer_site_id' => $site->id,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => [
            'status' => WorkOrderStatus::Scheduled,
            'scheduled_start' => now()->addDay()->setTime(9, 0),
            'scheduled_end' => now()->addDay()->setTime(11, 0),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => ['status' => WorkOrderStatus::InProgress]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => WorkOrderStatus::Completed,
            'completed_at' => now(),
        ]);
    }
}
