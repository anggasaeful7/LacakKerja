<?php

namespace Database\Factories;

use App\Enums\InvitationStatus;
use App\Enums\OrganizationRole;
use App\Models\Invitation;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Invitation> */
class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        $token = Str::random(64);

        return [
            'organization_id' => Organization::factory(),
            'invited_by' => User::factory(),
            'email' => fake()->unique()->safeEmail(),
            'role' => OrganizationRole::Technician,
            'status' => InvitationStatus::Pending,
            'token_hash' => Invitation::hashToken($token),
            'expires_at' => now()->addDays(7),
            'accepted_at' => null,
            'declined_at' => null,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => ['expires_at' => now()->subMinute()]);
    }
}
