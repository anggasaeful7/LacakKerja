<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use Carbon\CarbonImmutable;
use Database\Factories\MembershipFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $user_id
 * @property OrganizationRole $role
 * @property MembershipStatus $status
 * @property CarbonImmutable|null $joined_at
 * @property CarbonImmutable|null $invited_at
 */
#[Fillable(['organization_id', 'user_id', 'role', 'status', 'joined_at', 'invited_at'])]
class Membership extends Model
{
    /** @use HasFactory<MembershipFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'role' => OrganizationRole::class,
            'status' => MembershipStatus::class,
            'joined_at' => 'immutable_datetime',
            'invited_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === MembershipStatus::Active;
    }

    public function hasRole(OrganizationRole ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function canManageMembers(): bool
    {
        return $this->isActive() && $this->role->canManageMembers();
    }
}
