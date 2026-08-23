<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, Service $service): bool
    {
        return $user->canAccessOrganization($service->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    public function update(User $user, Service $service): bool
    {
        return $user->membershipFor($service->organization_id)?->role->canManageMasterData() ?? false;
    }

    public function delete(User $user, Service $service): bool
    {
        return $this->update($user, $service);
    }
}
