<?php

use App\Enums\InvitationStatus;
use App\Enums\OrganizationRole;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

it('creates a hashed, expiring invitation for a permitted role', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $response = $this->actingAs($owner)->post(route('organization.invitations.store'), [
        'email' => 'new-tech@example.com',
        'role' => OrganizationRole::Technician->value,
    ]);

    $response->assertRedirect();
    $token = Str::afterLast((string) session('invitation_url'), '/');
    $invitation = Invitation::query()->where('email', 'new-tech@example.com')->firstOrFail();

    expect($token)->not->toBeEmpty();
    expect($invitation->token_hash)->toBe(Invitation::hashToken($token));
    expect($invitation->token_hash)->not->toBe($token);
    expect($invitation->status)->toBe(InvitationStatus::Pending);
    expect($invitation->expires_at->isFuture())->toBeTrue();
});

it('allows only the invited email to accept an invitation', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    $invited = User::factory()->create(['email' => 'invitee@example.com']);
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $token = Str::random(64);
    $invitation = Invitation::create([
        'organization_id' => $organization->id,
        'invited_by' => $owner->id,
        'email' => $invited->email,
        'role' => OrganizationRole::Dispatcher,
        'status' => InvitationStatus::Pending,
        'token_hash' => Invitation::hashToken($token),
        'expires_at' => now()->addDay(),
    ]);

    $this->actingAs(User::factory()->create(['email' => 'other@example.com']))
        ->post(route('invitations.accept', $token))
        ->assertForbidden();

    $this->actingAs($invited)
        ->post(route('invitations.accept', $token))
        ->assertRedirect(route('dashboard'));

    expect($invitation->fresh()->status)->toBe(InvitationStatus::Accepted);
    expect(Membership::query()->where('organization_id', $organization->id)->where('user_id', $invited->id)->value('role'))
        ->toBe(OrganizationRole::Dispatcher);
    expect($invited->fresh()->current_organization_id)->toBe($organization->id);
});

it('rejects expired invitations and marks them expired', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    $recipient = User::factory()->create(['email' => 'expired@example.com']);
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);

    $token = Str::random(64);
    $invitation = Invitation::create([
        'organization_id' => $organization->id,
        'invited_by' => $owner->id,
        'email' => $recipient->email,
        'role' => OrganizationRole::Technician,
        'status' => InvitationStatus::Pending,
        'token_hash' => Invitation::hashToken($token),
        'expires_at' => now()->subMinute(),
    ]);

    $this->get(route('invitations.show', $token))->assertOk();
    expect($invitation->fresh()->status)->toBe(InvitationStatus::Expired);

    $this->actingAs($recipient)
        ->post(route('invitations.accept', $token))
        ->assertStatus(410);

    expect(Membership::query()->where('organization_id', $organization->id)->where('user_id', $recipient->id)->exists())
        ->toBeFalse();
});

it('does not allow owner role through the invitation form', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $this->actingAs($owner)
        ->from(route('organization.members'))
        ->post(route('organization.invitations.store'), [
            'email' => 'owner-invite@example.com',
            'role' => OrganizationRole::Owner->value,
        ])
        ->assertSessionHasErrors('role');

    expect(Invitation::query()->where('email', 'owner-invite@example.com')->exists())->toBeFalse();
});
