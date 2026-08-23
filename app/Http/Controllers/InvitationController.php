<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Enums\MembershipStatus;
use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(string $token): View
    {
        $invitation = Invitation::query()
            ->with('organization')
            ->where('token_hash', Invitation::hashToken($token))
            ->first();

        if ($invitation?->markExpiredIfNeeded()) {
            $invitation->refresh();
        }

        return view('pages.invitations.show', [
            'invitation' => $invitation,
            'token' => $token,
        ]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        $user = $request->user();
        $invitation = $this->pendingInvitation($token);

        abort_unless(Str::lower($user->email) === Str::lower($invitation->email), 403, 'Email akun tidak cocok dengan undangan.');

        DB::transaction(function () use ($invitation, $user): void {
            $membership = Membership::query()->firstOrNew([
                'organization_id' => $invitation->organization_id,
                'user_id' => $user->id,
            ]);
            $membership->fill([
                'role' => $invitation->role,
                'status' => MembershipStatus::Active,
                'joined_at' => now(),
                'invited_at' => $membership->invited_at ?? $invitation->created_at,
            ]);
            $membership->save();

            $invitation->update([
                'status' => InvitationStatus::Accepted,
                'accepted_at' => now(),
            ]);

            $user->forceFill(['current_organization_id' => $invitation->organization_id])->save();
        });

        return redirect()->route('dashboard')->with('status', "Kamu bergabung ke {$invitation->organization->name}.");
    }

    public function decline(Request $request, string $token): RedirectResponse
    {
        $invitation = $this->pendingInvitation($token);
        abort_unless(Str::lower($request->user()->email) === Str::lower($invitation->email), 403, 'Email akun tidak cocok dengan undangan.');

        $invitation->update([
            'status' => InvitationStatus::Declined,
            'declined_at' => now(),
        ]);

        return redirect()->route('home')->with('status', 'Undangan ditolak.');
    }

    private function pendingInvitation(string $token): Invitation
    {
        $invitation = Invitation::query()
            ->with('organization')
            ->where('token_hash', Invitation::hashToken($token))
            ->firstOrFail();

        if ($invitation->markExpiredIfNeeded()) {
            abort(410, 'Undangan sudah kedaluwarsa.');
        }

        abort_unless($invitation->isPending(), 410, 'Undangan tidak lagi aktif.');

        return $invitation;
    }
}
