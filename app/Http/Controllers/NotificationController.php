<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Services\CurrentOrganization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $unreadOnly = $request->boolean('unread');
        $notifications = $this->scopedQuery($request, $organization)
            ->when($unreadOnly, fn (Builder $query): Builder => $query->whereNull('read_at'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $unreadCount = $this->scopedQuery($request, $organization)->whereNull('read_at')->count();

        return view('pages.notifications.index', compact('organization', 'notifications', 'unreadOnly', 'unreadCount'));
    }

    public function read(Request $request, string $notification): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $record = $this->scopedQuery($request, $organization)->whereKey($notification)->firstOrFail();
        $record->markAsRead();

        return back()->with('status', 'Notifikasi ditandai sudah dibaca.');
    }

    public function readAll(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->scopedQuery($request, $organization)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('status', 'Semua notifikasi sudah dibaca.');
    }

    /** @return MorphMany<DatabaseNotification, User> */
    private function scopedQuery(Request $request, Organization $organization): MorphMany
    {
        return $request->user()->notifications()
            ->whereJsonContains('data->organization_id', $organization->id);
    }
}
