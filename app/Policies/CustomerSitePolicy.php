<?php

namespace App\Policies;

use App\Models\CustomerSite;
use App\Models\Organization;
use App\Models\User;

class CustomerSitePolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, CustomerSite $site): bool
    {
        return $user->canAccessOrganization($site->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    public function update(User $user, CustomerSite $site): bool
    {
        return $user->membershipFor($site->organization_id)?->role->canManageMasterData() ?? false;
    }

    public function delete(User $user, CustomerSite $site): bool
    {
        return $this->update($user, $site);
    }
}
