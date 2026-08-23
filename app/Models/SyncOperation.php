<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\SyncOperationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $user_id
 * @property string $client_operation_id
 * @property string $type
 * @property int|null $work_order_id
 * @property int $base_version
 * @property string $payload_hash
 * @property array<string, mixed> $payload
 * @property string $state
 * @property array<string, mixed>|null $response
 */
#[Fillable(['organization_id', 'user_id', 'client_operation_id', 'type', 'work_order_id', 'base_version', 'payload_hash', 'payload', 'state', 'response', 'processed_at'])]
class SyncOperation extends Model
{
    /** @use HasFactory<SyncOperationFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'response' => 'array',
            'base_version' => 'integer',
            'processed_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
