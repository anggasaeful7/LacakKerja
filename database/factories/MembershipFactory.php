<?php

namespace Database\Factories;

use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Membership> */
class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'role' => OrganizationRole::Technician,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
            'invited_at' => null,
        ];
    }

    public function owner(): static
    {
        return $this->state(fn () => ['role' => OrganizationRole::Owner]);
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => OrganizationRole::Admin]);
    }

    public function dispatcher(): static
    {
        return $this->state(fn () => ['role' => OrganizationRole::Dispatcher]);
    }

    public function suspended(): static
    {
        return $this->state(fn () => ['status' => MembershipStatus::Suspended]);
    }
}
