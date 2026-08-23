<?php

namespace Database\Factories;

use App\Enums\NotificationEvent;
use App\Models\NotificationPreference;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<NotificationPreference> */
class NotificationPreferenceFactory extends Factory
{
    protected $model = NotificationPreference::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'event' => NotificationEvent::Assigned,
            'in_app' => true,
            'email' => true,
        ];
    }
}
