<?php

namespace App\Policies;

use App\Enums\OrganizationRole;
use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->activeMemberships()->exists();
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function create(User $user): bool
    {
        return $user->activeMemberships()->doesntExist();
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->hasRole(OrganizationRole::Owner, OrganizationRole::Admin) ?? false;
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->hasRole(OrganizationRole::Owner) ?? false;
    }
}
