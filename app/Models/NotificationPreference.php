<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\NotificationEvent;
use Database\Factories\NotificationPreferenceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $user_id
 * @property NotificationEvent $event
 * @property bool $in_app
 * @property bool $email
 */
#[Fillable(['organization_id', 'user_id', 'event', 'in_app', 'email'])]
class NotificationPreference extends Model
{
    /** @use HasFactory<NotificationPreferenceFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'event' => NotificationEvent::class,
            'in_app' => 'boolean',
            'email' => 'boolean',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
