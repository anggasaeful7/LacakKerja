<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function onboarding(Request $request): View|RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->resolve($request->user());

        if ($organization !== null) {
            return redirect()->route('dashboard');
        }

        return view('pages.organization.onboarding');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        Gate::forUser($user)->authorize('create', Organization::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'timezone' => ['required', 'timezone'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $organization = DB::transaction(function () use ($validated, $user): Organization {
            $organization = Organization::create([
                ...$validated,
                'currency' => Str::upper($validated['currency']),
                'slug' => $this->uniqueSlug($validated['name']),
                'settings' => [
                    'week_starts_on' => 1,
                    'date_format' => 'd M Y',
                ],
            ]);

            Membership::create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'role' => OrganizationRole::Owner,
                'status' => MembershipStatus::Active,
                'joined_at' => now(),
            ]);

            $user->forceFill(['current_organization_id' => $organization->id])->save();

            return $organization;
        });

        return redirect()->route('dashboard')->with('status', "Organisasi {$organization->name} berhasil dibuat.");
    }

    public function switch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
        ]);

        $organization = Organization::query()->whereKey($validated['organization_id'])->firstOrFail();
        app(CurrentOrganization::class)->switch($request->user(), $organization);

        return back()->with('status', "Konteks berpindah ke {$organization->name}.");
    }

    public function settings(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $organization);

        return view('pages.organization.settings', compact('organization'));
    }

    public function update(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $organization);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'slug' => ['required', 'alpha_dash', 'min:3', 'max:80', Rule::unique('organizations', 'slug')->ignore($organization)],
            'timezone' => ['required', 'timezone'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $organization->update([
            ...$validated,
            'slug' => Str::lower($validated['slug']),
            'currency' => Str::upper($validated['currency']),
        ]);

        return back()->with('status', 'Pengaturan organisasi diperbarui.');
    }

    public function members(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [Membership::class, $organization]);

        $memberships = $organization->memberships()
            ->with('user')
            ->orderByRaw("CASE role WHEN 'owner' THEN 0 WHEN 'admin' THEN 1 WHEN 'dispatcher' THEN 2 ELSE 3 END")
            ->orderBy('created_at')
            ->paginate(20);

        $invitations = $organization->invitations()
            ->with('inviter')
            ->where('status', InvitationStatus::Pending)
            ->where('expires_at', '>', now())
            ->latest()
            ->limit(10)
            ->get();

        return view('pages.organization.members', compact('organization', 'memberships', 'invitations'));
    }

    public function invite(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Membership::class, $organization]);

        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
            'role' => ['required', Rule::enum(OrganizationRole::class), Rule::notIn([OrganizationRole::Owner->value])],
        ]);

        $email = Str::lower($validated['email']);
        $existingUser = User::query()->where('email', $email)->first();

        if ($existingUser?->membershipFor($organization)?->isActive()) {
            throw ValidationException::withMessages(['email' => 'User sudah menjadi anggota organisasi ini.']);
        }

        $organization->invitations()
            ->where('email', $email)
            ->where('status', InvitationStatus::Pending)
            ->update(['status' => InvitationStatus::Revoked]);

        $token = Str::random(64);
        $invitation = $organization->invitations()->create([
            'invited_by' => $request->user()->id,
            'email' => $email,
            'role' => OrganizationRole::from($validated['role']),
            'status' => InvitationStatus::Pending,
            'token_hash' => Invitation::hashToken($token),
            'expires_at' => Invitation::expiresAt(),
        ]);

        return back()
            ->with('status', "Undangan untuk {$invitation->email} dibuat.")
            ->with('invitation_url', $invitation->tokenUrl($token));
    }

    public function updateMembership(Request $request, Membership $membership): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $membership);

        abort_unless($membership->organization_id === $organization->id, 404);

        $validated = $request->validate([
            'role' => ['required', Rule::enum(OrganizationRole::class)],
            'status' => ['required', Rule::enum(MembershipStatus::class)],
        ]);

        $role = OrganizationRole::from($validated['role']);
        $status = MembershipStatus::from($validated['status']);
        $removingLastOwner = $membership->role === OrganizationRole::Owner
            && ($role !== OrganizationRole::Owner || $status !== MembershipStatus::Active)
            && $organization->ownerCount() <= 1;

        if ($removingLastOwner) {
            throw ValidationException::withMessages(['role' => 'Organisasi harus selalu memiliki setidaknya satu Owner aktif.']);
        }

        $membership->update([
            'role' => $role,
            'status' => $status,
            'joined_at' => $status === MembershipStatus::Active ? ($membership->joined_at ?? now()) : $membership->joined_at,
        ]);

        if ($membership->user_id === $request->user()->id && $status !== MembershipStatus::Active) {
            app(CurrentOrganization::class)->resolve($request->user());
        }

        return back()->with('status', 'Membership diperbarui.');
    }

    public function removeMembership(Request $request, Membership $membership): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('delete', $membership);
        abort_unless($membership->organization_id === $organization->id, 404);

        $membership->delete();

        if ($membership->user_id === $request->user()->id) {
            app(CurrentOrganization::class)->resolve($request->user());
        }

        return back()->with('status', 'Membership dihapus.');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'organisasi';
        $slug = $base;
        $suffix = 2;

        while (Organization::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
