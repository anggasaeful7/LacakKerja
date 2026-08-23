<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\Organization;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user, Organization $organization): bool
    {
        return $this->canManageBilling($user, $organization->id);
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id);
    }

    public function create(User $user, Organization $organization): bool
    {
        return $this->canManageBilling($user, $organization->id);
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id) && $invoice->isEditable();
    }

    public function issue(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id) && $invoice->isEditable();
    }

    public function void(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id);
    }

    public function revise(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id);
    }

    public function recordPayment(User $user, Invoice $invoice): bool
    {
        return $this->canManageBilling($user, $invoice->organization_id);
    }

    private function canManageBilling(User $user, int $organizationId): bool
    {
        return $user->membershipFor($organizationId)?->role->canManageMasterData() ?? false;
    }
}
