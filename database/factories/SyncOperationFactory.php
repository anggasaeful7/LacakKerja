<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\SyncOperation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<SyncOperation> */
class SyncOperationFactory extends Factory
{
    protected $model = SyncOperation::class;

    public function definition(): array
    {
        $payload = ['value' => 'offline'];

        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'client_operation_id' => (string) Str::uuid(),
            'type' => 'checklist.update',
            'work_order_id' => null,
            'base_version' => 1,
            'payload_hash' => hash('sha256', json_encode($payload, JSON_THROW_ON_ERROR)),
            'payload' => $payload,
            'state' => 'synced',
            'response' => ['state' => 'synced'],
            'processed_at' => now(),
        ];
    }
}
