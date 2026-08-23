<x-layouts::app.sidebar :title="__('Audit log')">
    <flux:main class="min-h-full bg-background px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">
            <header>
                <p class="text-sm font-medium text-accent">Governance</p>
                <flux:heading size="xl" class="mt-1">Audit log</flux:heading>
                <p class="mt-2 max-w-2xl text-sm text-muted-foreground">Riwayat perubahan sensitif di organisasi. Data rahasia otomatis disamarkan sebelum disimpan.</p>
            </header>

            <form method="GET" class="lk-panel grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-5 lg:items-end" aria-label="Filter audit log">
                <div><label for="audit-event" class="mb-2 block text-sm font-medium text-foreground">Event</label><select id="audit-event" name="event" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><option value="">Semua event</option>@foreach($events as $availableEvent)<option value="{{ $availableEvent }}" @selected($event === $availableEvent)>{{ str($availableEvent)->replace('.', ' · ')->replace('_', ' ')->title() }}</option>@endforeach</select></div>
                <div><label for="audit-actor" class="mb-2 block text-sm font-medium text-foreground">Actor</label><select id="audit-actor" name="actor_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><option value="">Semua actor</option>@foreach($actors as $actor)<option value="{{ $actor->user_id }}" @selected((int) $actorId === (int) $actor->user_id)>{{ $actor->user->name }}</option>@endforeach</select></div>
                <div><label for="audit-from" class="mb-2 block text-sm font-medium text-foreground">Dari</label><input id="audit-from" name="from" type="date" value="{{ $from?->toDateString() }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div>
                <div><label for="audit-to" class="mb-2 block text-sm font-medium text-foreground">Sampai</label><input id="audit-to" name="to" type="date" value="{{ $to?->toDateString() }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div>
                <div><flux:button type="submit" variant="primary" icon="funnel" class="min-h-11 w-full">Terapkan</flux:button></div>
            </form>

            <section class="lk-panel overflow-hidden" aria-labelledby="audit-list-title">
                <div class="border-b border-border px-5 py-5 sm:px-6"><h2 id="audit-list-title" class="font-semibold text-foreground">Perubahan tercatat</h2><p class="mt-1 text-sm text-muted-foreground">{{ $logs->total() }} event sesuai filter.</p></div>
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-start text-sm"><caption class="sr-only">Daftar audit log organisasi</caption><thead class="bg-surface-subtle text-xs uppercase tracking-wider text-muted-foreground"><tr><th scope="col" class="px-5 py-3 text-start">Waktu</th><th scope="col" class="px-5 py-3 text-start">Event</th><th scope="col" class="px-5 py-3 text-start">Actor</th><th scope="col" class="px-5 py-3 text-start">Subject</th><th scope="col" class="px-5 py-3 text-start">Perubahan</th></tr></thead><tbody class="divide-y divide-border">@forelse($logs as $log)<tr class="align-top"><td class="whitespace-nowrap px-5 py-4 text-muted-foreground">{{ $log->created_at?->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</td><td class="px-5 py-4"><span class="font-semibold text-foreground">{{ $log->eventLabel() }}</span><span class="mt-1 block text-xs text-muted-foreground">{{ $log->event }}</span></td><td class="px-5 py-4 text-foreground">{{ $log->actor?->name ?? 'System' }}</td><td class="px-5 py-4 text-muted-foreground">{{ class_basename((string) $log->subject_type) ?: '—' }}{{ $log->subject_id ? ' #'.$log->subject_id : '' }}</td><td class="max-w-md px-5 py-4"><code class="whitespace-pre-wrap break-words text-xs text-muted-foreground">{{ json_encode($log->changes ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</code></td></tr>@empty<tr><td colspan="5" class="px-5 py-14 text-center"><x-lk-empty-state icon="shield-check" title="Belum ada audit event" description="Perubahan penting akan muncul setelah aktivitas organisasi berjalan." /></td></tr>@endforelse</tbody></table>
                </div>
            </section>
            @if($logs->hasPages())<div>{{ $logs->links() }}</div>@endif
        </div>
    </flux:main>
</x-layouts::app.sidebar>