<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CurrentOrganization
{
    public function resolve(User $user): ?Organization
    {
        $requestedId = $user->current_organization_id;

        if ($requestedId !== null) {
            $membership = $user->activeMemberships()
                ->with('organization')
                ->where('organization_id', $requestedId)
                ->first();

            if ($membership?->organization !== null && ! $membership->organization->trashed()) {
                return $membership->organization;
            }
        }

        $membership = $user->activeMemberships()
            ->with('organization')
            ->orderBy('joined_at')
            ->orderBy('id')
            ->first();

        if ($membership?->organization === null || $membership->organization->trashed()) {
            if ($user->current_organization_id !== null) {
                $user->forceFill(['current_organization_id' => null])->saveQuietly();
            }

            return null;
        }

        if ($user->current_organization_id !== $membership->organization_id) {
            $user->forceFill(['current_organization_id' => $membership->organization_id])->saveQuietly();
        }

        return $membership->organization;
    }

    public function get(): ?Organization
    {
        return request()->attributes->get('currentOrganization');
    }

    public function require(User $user): Organization
    {
        $organization = $this->get() ?? $this->resolve($user);

        abort_if($organization === null, 409, 'No active organization context is available.');

        return $organization;
    }

    public function membership(User $user, Organization|int $organization): ?Membership
    {
        $organizationId = $organization instanceof Organization ? $organization->getKey() : $organization;

        return $user->activeMemberships()
            ->where('organization_id', $organizationId)
            ->first();
    }

    public function switch(User $user, Organization $organization): Organization
    {
        abort_unless($this->membership($user, $organization) !== null, 403);

        DB::transaction(function () use ($user, $organization): void {
            $user->forceFill(['current_organization_id' => $organization->getKey()])->save();
        });

        return $organization;
    }

    public function clear(User $user): void
    {
        $user->forceFill(['current_organization_id' => null])->save();
    }
}
