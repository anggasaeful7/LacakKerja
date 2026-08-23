<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ActivityLog> */
class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'actor_id' => User::factory(),
            'event' => 'test.event',
            'changes' => [],
            'metadata' => [],
            'created_at' => now(),
        ];
    }
}
