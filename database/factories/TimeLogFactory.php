<?php

namespace Database\Factories;

use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TimeLog> */
class TimeLogFactory extends Factory
{
    protected $model = TimeLog::class;

    public function definition(): array
    {
        $started = now()->subHour();

        return [
            'work_order_id' => WorkOrder::factory(),
            'user_id' => User::factory(),
            'started_at' => $started,
            'ended_at' => $started->copy()->addMinutes(60),
            'duration_minutes' => 60,
            'notes' => null,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'started_at' => now(),
            'ended_at' => null,
            'duration_minutes' => null,
        ]);
    }
}
