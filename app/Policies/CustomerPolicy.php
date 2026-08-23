<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->canAccessOrganization($customer->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->membershipFor($customer->organization_id)?->role->canManageMasterData() ?? false;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $this->update($user, $customer);
    }
}
