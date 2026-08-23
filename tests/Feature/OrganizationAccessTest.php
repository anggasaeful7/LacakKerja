<?php

use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;

it('lets a verified user create their first organization during onboarding', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('onboarding.organization'))
        ->assertOk();

    $response = $this->post(route('onboarding.organization.store'), [
        'name' => 'Prima Teknik',
        'timezone' => 'Asia/Jakarta',
        'currency' => 'idr',
    ]);

    $response->assertRedirect(route('dashboard'));

    $organization = Organization::query()->where('name', 'Prima Teknik')->firstOrFail();
    expect($user->fresh()->current_organization_id)->toBe($organization->id);
    expect(Membership::query()->where('organization_id', $organization->id)->where('user_id', $user->id)->value('role'))
        ->toBe(OrganizationRole::Owner);
});

it('isolates organization routes from guessed membership and organization ids', function () {
    $organizationA = Organization::factory()->create();
    $organizationB = Organization::factory()->create();
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    Membership::factory()->owner()->create(['organization_id' => $organizationA->id, 'user_id' => $userA->id]);
    $membershipB = Membership::factory()->owner()->create(['organization_id' => $organizationB->id, 'user_id' => $userB->id]);
    $userA->update(['current_organization_id' => $organizationA->id]);
    $userB->update(['current_organization_id' => $organizationB->id]);

    $this->actingAs($userA)
        ->get(route('organization.members'))
        ->assertOk();

    $this->patch(route('organization.members.update', $membershipB), [
        'role' => OrganizationRole::Admin->value,
        'status' => MembershipStatus::Active->value,
    ])->assertForbidden();

    $this->post(route('organization.switch'), ['organization_id' => $organizationB->id])
        ->assertForbidden();

    $this->delete(route('organization.members.destroy', $membershipB))
        ->assertForbidden();
});

it('allows only owner and admin to manage team members', function () {
    $organization = Organization::factory()->create();
    $technician = User::factory()->create();
    $dispatcher = User::factory()->create();
    $admin = User::factory()->create();

    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => User::factory()->create()->id]);
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id]);
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    Membership::factory()->admin()->create(['organization_id' => $organization->id, 'user_id' => $admin->id]);
    $technician->update(['current_organization_id' => $organization->id]);
    $dispatcher->update(['current_organization_id' => $organization->id]);
    $admin->update(['current_organization_id' => $organization->id]);

    $this->actingAs($technician)->get(route('organization.members'))->assertForbidden();
    $this->actingAs($dispatcher)->get(route('organization.members'))->assertForbidden();
    $this->actingAs($admin)->get(route('organization.members'))->assertOk();
});

it('protects the last active owner from demotion or suspension', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    $membership = Membership::factory()->owner()->create([
        'organization_id' => $organization->id,
        'user_id' => $owner->id,
    ]);
    $owner->update(['current_organization_id' => $organization->id]);

    $this->actingAs($owner)
        ->patch(route('organization.members.update', $membership), [
            'role' => OrganizationRole::Admin->value,
            'status' => MembershipStatus::Suspended->value,
        ])
        ->assertForbidden();

    expect($membership->fresh()->role)->toBe(OrganizationRole::Owner);
    expect($membership->fresh()->status)->toBe(MembershipStatus::Active);
});

it('redirects a suspended member away from the organization context', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create();
    Membership::factory()->suspended()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);
    $user->update(['current_organization_id' => $organization->id]);

    $this->actingAs($user)
        ->get(route('organization.members'))
        ->assertRedirect(route('onboarding.organization'));
});

it('allows organization managers to update organization settings', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $this->actingAs($owner)
        ->get(route('organization.settings'))
        ->assertOk();

    $this->put(route('organization.settings.update'), [
        'name' => 'Updated Service Co',
        'slug' => 'updated-service-co',
        'timezone' => 'Asia/Jakarta',
        'currency' => 'IDR',
    ])->assertRedirect();

    expect($organization->fresh()->name)->toBe('Updated Service Co');
    expect($organization->fresh()->slug)->toBe('updated-service-co');
});

it('lets a manager suspend and reactivate a non-owner member', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    $technician = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $technicianMembership = Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $this->actingAs($owner)
        ->patch(route('organization.members.update', $technicianMembership), [
            'role' => OrganizationRole::Technician->value,
            'status' => MembershipStatus::Suspended->value,
        ])
        ->assertRedirect();

    expect($technicianMembership->fresh()->status)->toBe(MembershipStatus::Suspended);

    $this->patch(route('organization.members.update', $technicianMembership), [
        'role' => OrganizationRole::Technician->value,
        'status' => MembershipStatus::Active->value,
    ])->assertRedirect();

    expect($technicianMembership->fresh()->status)->toBe(MembershipStatus::Active);
});
