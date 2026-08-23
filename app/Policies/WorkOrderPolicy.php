<?php

namespace App\Policies;

use App\Enums\OrganizationRole;
use App\Enums\WorkOrderStatus;
use App\Models\Organization;
use App\Models\User;
use App\Models\WorkOrder;

class WorkOrderPolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $user->canAccessOrganization($organization);
    }

    public function view(User $user, WorkOrder $workOrder): bool
    {
        if (! $user->canAccessOrganization($workOrder->organization_id)) {
            return false;
        }

        return $this->isManager($user, $workOrder->organization_id)
            || $workOrder->assignments()->where('user_id', $user->id)->exists();
    }

    public function create(User $user, Organization $organization): bool
    {
        return $this->isManager($user, $organization->id);
    }

    public function update(User $user, WorkOrder $workOrder): bool
    {
        if ($workOrder->isLocked() || ! $user->canAccessOrganization($workOrder->organization_id)) {
            return false;
        }

        return $this->isManager($user, $workOrder->organization_id);
    }

    public function transition(User $user, WorkOrder $workOrder): bool
    {
        if (! $user->canAccessOrganization($workOrder->organization_id)) {
            return false;
        }

        if ($workOrder->status === WorkOrderStatus::Completed && ! $this->isAdmin($user, $workOrder->organization_id)) {
            return false;
        }

        return $this->isManager($user, $workOrder->organization_id)
            || $workOrder->assignments()->where('user_id', $user->id)->exists();
    }

    public function complete(User $user, WorkOrder $workOrder): bool
    {
        return $this->transition($user, $workOrder);
    }

    public function addNote(User $user, WorkOrder $workOrder): bool
    {
        return $this->transition($user, $workOrder);
    }

    public function updateChecklist(User $user, WorkOrder $workOrder): bool
    {
        return $this->transition($user, $workOrder);
    }

    public function trackTime(User $user, WorkOrder $workOrder): bool
    {
        return $this->transition($user, $workOrder);
    }

    public function attach(User $user, WorkOrder $workOrder): bool
    {
        return $this->transition($user, $workOrder);
    }

    private function isManager(User $user, int $organizationId): bool
    {
        return $user->membershipFor($organizationId)?->role->canManageMasterData() ?? false;
    }

    private function isAdmin(User $user, int $organizationId): bool
    {
        return in_array($user->membershipFor($organizationId)?->role, [OrganizationRole::Owner, OrganizationRole::Admin], true);
    }
}
