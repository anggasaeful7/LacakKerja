<?php

namespace App\Policies;

use App\Models\ChecklistTemplate;
use App\Models\Organization;
use App\Models\User;

class ChecklistTemplatePolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, ChecklistTemplate $template): bool
    {
        return $user->canAccessOrganization($template->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $user->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    public function update(User $user, ChecklistTemplate $template): bool
    {
        return $user->membershipFor($template->organization_id)?->role->canManageMasterData() ?? false;
    }

    public function delete(User $user, ChecklistTemplate $template): bool
    {
        return $this->update($user, $template);
    }
}
