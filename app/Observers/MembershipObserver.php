<?php

namespace App\Observers;

use App\Enums\NotificationEvent;
use App\Models\Membership;
use App\Models\Organization;
use App\Services\AuditLogger;
use App\Services\DomainNotifier;

class MembershipObserver
{
    public function updated(Membership $membership): void
    {
        if (! $membership->wasChanged(['role', 'status'])) {
            return;
        }

        $organization = Organization::query()->find($membership->organization_id);
        if ($organization === null) {
            return;
        }

        app(AuditLogger::class)->log('membership.role_changed', $membership, changes: [
            'role' => [$membership->getRawOriginal('role'), $membership->role->value],
            'status' => [$membership->getRawOriginal('status'), $membership->status->value],
        ]);

        app(DomainNotifier::class)->notifyUsers($organization, NotificationEvent::RoleChanged, [(int) $membership->user_id], [
            'title' => 'Peran organisasi diperbarui',
            'body' => 'Peran kamu sekarang '.$membership->role->label().'.',
            'route' => route('organization.members'),
            'severity' => 'info',
            'subject_type' => $membership->getMorphClass(),
            'subject_id' => $membership->id,
        ]);
    }

    public function created(Membership $membership): void
    {
        app(AuditLogger::class)->log('membership.created', $membership, changes: [
            'role' => $membership->role->value,
            'status' => $membership->status->value,
        ]);
    }

    public function deleted(Membership $membership): void
    {
        app(AuditLogger::class)->log('membership.deleted', $membership, changes: [
            'user_id' => $membership->user_id,
            'role' => $membership->role->value,
        ], organizationId: $membership->organization_id);
    }
}
