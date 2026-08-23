<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\Organization;
use App\Models\User;

class AssetPolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, Asset $asset): bool
    {
        return $user->canAccessOrganization($asset->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    public function update(User $user, Asset $asset): bool
    {
        return $user->membershipFor($asset->organization_id)?->role->canManageMasterData() ?? false;
    }

    public function delete(User $user, Asset $asset): bool
    {
        return $this->update($user, $asset);
    }
}
