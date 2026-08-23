<?php

namespace App\Services;

use App\Enums\MembershipStatus;
use App\Enums\NotificationEvent;
use App\Enums\OrganizationRole;
use App\Jobs\DeliverNotificationEmail;
use App\Models\NotificationPreference;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\FieldServiceNotification;
use Illuminate\Database\Eloquent\Builder;

class DomainNotifier
{
    /**
     * @param  array<int, int>  $userIds
     * @param  array<string, mixed>  $payload
     */
    public function notifyUsers(Organization $organization, NotificationEvent $event, array $userIds, array $payload): void
    {
        $ids = collect($userIds)->map(fn (int|string $id): int => (int) $id)->unique()->values()->all();
        if ($ids === []) {
            return;
        }

        $users = User::query()
            ->whereIn('id', $ids)
            ->whereHas('memberships', fn (Builder $query): Builder => $query
                ->where('organization_id', $organization->id)
                ->where('status', MembershipStatus::Active->value))
            ->get();
        $preferences = NotificationPreference::query()
            ->forOrganization($organization)
            ->where('event', $event->value)
            ->whereIn('user_id', $users->pluck('id')->all())
            ->get()
            ->keyBy('user_id');

        foreach ($users as $user) {
            $preference = $preferences->get($user->id);
            $inApp = $preference === null ? true : $preference->in_app;
            $email = $preference === null ? true : $preference->email;
            $notification = new FieldServiceNotification($organization, $event, $payload);

            if ($inApp) {
                $user->notify($notification);
            }

            if ($email) {
                DeliverNotificationEmail::dispatch(
                    $user->id,
                    $organization->id,
                    $event->value,
                    $payload,
                )->onConnection('database')->onQueue('notifications');
            }
        }
    }

    /**
     * @param  array<int, int>  $userIds
     * @param  array<string, mixed>  $payload
     */
    public function notifyTechnicians(Organization $organization, NotificationEvent $event, array $userIds, array $payload): void
    {
        $this->notifyUsers($organization, $event, $userIds, $payload);
    }

    /** @param array<string, mixed> $payload */
    public function notifyManagers(Organization $organization, NotificationEvent $event, array $payload): void
    {
        $userIds = $organization->activeMembers()
            ->whereIn('role', [OrganizationRole::Owner->value, OrganizationRole::Admin->value, OrganizationRole::Dispatcher->value])
            ->pluck('user_id')
            ->map(fn (int|string $id): int => (int) $id)
            ->all();

        $this->notifyUsers($organization, $event, $userIds, $payload);
    }
}
