<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\ActivityLogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $organization_id
 * @property int|null $actor_id
 * @property string $event
 * @property array<string, mixed>|null $changes
 * @property array<string, mixed>|null $metadata
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $request_id
 */
#[Fillable(['organization_id', 'actor_id', 'event', 'subject_type', 'subject_id', 'changes', 'metadata', 'ip_address', 'user_agent', 'request_id', 'created_at'])]
class ActivityLog extends Model
{
    /** @use HasFactory<ActivityLogFactory> */
    use BelongsToOrganization, HasFactory;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'changes' => 'array',
            'metadata' => 'array',
            'created_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /** @return MorphTo<Model, $this> */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function eventLabel(): string
    {
        return str($this->event)
            ->replace('.', ' · ')
            ->replace('_', ' ')
            ->title()
            ->toString();
    }
}
