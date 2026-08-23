<?php

namespace App\Http\Controllers;

use App\Enums\NotificationEvent;
use App\Models\NotificationPreference;
use App\Services\CurrentOrganization;
use App\Services\NotificationPreferenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationPreferenceController extends Controller
{
    public function __construct(
        private readonly NotificationPreferenceService $preferenceService,
    ) {}

    public function edit(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $preferences = $this->preferenceService->forUser($request->user(), $organization);

        return view('pages.settings.notifications', compact('organization', 'preferences'));
    }

    public function update(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $validated = $request->validate([
            'preferences' => ['required', 'array'],
            'preferences.*' => ['array'],
            'preferences.*.in_app' => ['nullable', 'boolean'],
            'preferences.*.email' => ['nullable', 'boolean'],
        ]);
        $rows = $validated['preferences'];

        foreach (NotificationEvent::cases() as $event) {
            $row = $rows[$event->value] ?? [];
            NotificationPreference::query()->updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'user_id' => $request->user()->id,
                    'event' => $event->value,
                ],
                [
                    'in_app' => (bool) ($row['in_app'] ?? false),
                    'email' => (bool) ($row['email'] ?? false),
                ],
            );
        }

        return back()->with('status', 'Preferensi notifikasi disimpan.');
    }
}
