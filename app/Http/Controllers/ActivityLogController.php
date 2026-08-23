<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\CurrentOrganization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $membership = $request->user()->membershipFor($organization);
        abort_unless($membership?->role->canManageOrganization() ?? false, 403);

        $event = trim($request->string('event')->toString());
        $actorId = $request->integer('actor_id') ?: null;
        $from = $request->date('from')?->startOfDay();
        $to = $request->date('to')?->endOfDay();
        $query = ActivityLog::query()
            ->forOrganization($organization)
            ->with('actor')
            ->when($event !== '', fn (Builder $builder): Builder => $builder->where('event', $event))
            ->when($actorId !== null, fn (Builder $builder): Builder => $builder->where('actor_id', $actorId))
            ->when($from !== null, fn (Builder $builder): Builder => $builder->where('created_at', '>=', $from))
            ->when($to !== null, fn (Builder $builder): Builder => $builder->where('created_at', '<=', $to))
            ->latest('created_at');
        $logs = $query->paginate(25)->withQueryString();
        $events = ActivityLog::query()->forOrganization($organization)->select('event')->distinct()->orderBy('event')->pluck('event');
        $actors = $organization->activeMembers()->with('user')->get()->sortBy('user.name')->values();

        return view('pages.audit.index', compact('organization', 'logs', 'events', 'actors', 'event', 'actorId', 'from', 'to'));
    }
}
