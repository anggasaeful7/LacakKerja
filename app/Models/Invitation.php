<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\InvitationStatus;
use App\Enums\OrganizationRole;
use Carbon\CarbonImmutable;
use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $invited_by
 * @property string $email
 * @property OrganizationRole $role
 * @property InvitationStatus $status
 * @property string $token_hash
 * @property CarbonImmutable $expires_at
 * @property CarbonImmutable|null $accepted_at
 * @property CarbonImmutable|null $declined_at
 */
#[Fillable(['organization_id', 'invited_by', 'email', 'role', 'status', 'token_hash', 'expires_at', 'accepted_at', 'declined_at'])]
class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'role' => OrganizationRole::class,
            'status' => InvitationStatus::class,
            'expires_at' => 'immutable_datetime',
            'accepted_at' => 'immutable_datetime',
            'declined_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isPending(): bool
    {
        return $this->status === InvitationStatus::Pending && ! $this->isExpired();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function markExpiredIfNeeded(): bool
    {
        if ($this->status !== InvitationStatus::Pending || ! $this->isExpired()) {
            return false;
        }

        $this->update(['status' => InvitationStatus::Expired]);

        return true;
    }

    public function tokenUrl(string $token): string
    {
        return route('invitations.show', ['token' => $token]);
    }

    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public static function expiresAt(): CarbonImmutable
    {
        return CarbonImmutable::now()->addDays(7);
    }
}
