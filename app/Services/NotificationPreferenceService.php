<?php

namespace App\Services;

use App\Enums\NotificationEvent;
use App\Models\NotificationPreference;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationPreferenceService
{
    /** @return Collection<int, NotificationPreference> */
    public function forUser(User $user, Organization $organization): Collection
    {
        $existing = NotificationPreference::query()
            ->forOrganization($organization)
            ->where('user_id', $user->id)
            ->get()
            ->keyBy(fn (NotificationPreference $preference): string => $preference->event->value);

        return collect(NotificationEvent::cases())->map(function (NotificationEvent $event) use ($existing, $organization, $user): NotificationPreference {
            return $existing->get($event->value) ?? new NotificationPreference([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'event' => $event,
                'in_app' => true,
                'email' => true,
            ]);
        });
    }

    public function enabled(User $user, Organization $organization, NotificationEvent $event, string $channel): bool
    {
        $preference = NotificationPreference::query()
            ->forOrganization($organization)
            ->where('user_id', $user->id)
            ->where('event', $event->value)
            ->first();

        return $preference === null ? true : (bool) $preference->getAttribute($channel);
    }
}
