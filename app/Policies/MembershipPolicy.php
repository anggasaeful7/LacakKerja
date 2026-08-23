<?php

namespace App\Policies;

use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;

class MembershipPolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->canManageMembers() ?? false;
    }

    public function view(User $user, Membership $membership): bool
    {
        return $user->canAccessOrganization($membership->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->canManageMembers() ?? false;
    }

    public function update(User $user, Membership $membership): bool
    {
        $actor = $user->membershipFor($membership->organization_id);

        if ($actor === null || ! $actor->canManageMembers()) {
            return false;
        }

        if ($membership->user_id === $user->id && $membership->role === OrganizationRole::Owner) {
            return false;
        }

        if ($membership->role === OrganizationRole::Owner && $membership->organization->ownerCount() <= 1) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Membership $membership): bool
    {
        $actor = $user->membershipFor($membership->organization_id);

        if ($actor === null || ! $actor->canManageMembers()) {
            return false;
        }

        return ! ($membership->role === OrganizationRole::Owner
            && $membership->status === MembershipStatus::Active
            && $membership->organization->ownerCount() <= 1);
    }
}
