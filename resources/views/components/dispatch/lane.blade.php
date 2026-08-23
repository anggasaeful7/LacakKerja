@props(['title', 'laneKey', 'workOrders', 'technician' => null, 'technicians', 'filters', 'selectedDate'])
<section class="flex min-h-[18rem] flex-col rounded-card border border-border bg-surface" aria-labelledby="lane-{{ $laneKey }}">
    <div class="flex items-center gap-3 border-b border-border px-4 py-3"><span class="size-3 rounded-full" style="background-color: {{ $technician?->technicianProfile?->display_color ?? '#94a3b8' }}"></span><div class="min-w-0 flex-1"><h3 id="lane-{{ $laneKey }}" class="truncate font-semibold text-foreground">{{ $title }}</h3><p class="text-xs text-muted-foreground">{{ $workOrders->count() }} pekerjaan</p></div></div>
    <div class="flex flex-1 flex-col gap-3 p-3">
        @forelse($workOrders as $workOrder)
            <article class="rounded-control border border-border bg-background p-3 shadow-sm transition hover:border-accent/60">
                <div class="flex items-start justify-between gap-2"><a href="{{ route('work-orders.show', $workOrder) }}" class="font-semibold text-foreground hover:text-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate>{{ $workOrder->number }}</a><x-lk-priority-badge :priority="$workOrder->priority->value" /></div>
                <p class="mt-2 line-clamp-2 text-sm text-foreground">{{ $workOrder->title }}</p><p class="mt-2 text-xs text-muted-foreground">{{ $workOrder->customer->name }} · {{ $workOrder->site->city ?? $workOrder->site->name }}</p>
                <p class="mt-2 text-xs text-muted-foreground">@if($workOrder->scheduled_start){{ $workOrder->scheduled_start->format('H:i') }}–{{ $workOrder->scheduled_end?->format('H:i') }} · {{ $workOrder->scheduled_start->format('d M') }}@else Belum dijadwalkan @endif</p>
                <div class="mt-3 flex items-center justify-between gap-2"><x-lk-status-badge :status="$workOrder->status->value" />@if((int) $workOrder->getAttribute('schedule_conflict_count') > 0)<span class="text-xs font-semibold text-danger-content" role="status">Bentrok: {{ $workOrder->getAttribute('schedule_conflict_count') }} jadwal</span>@endif</div>
                <details class="mt-3"><summary class="min-h-11 cursor-pointer rounded-control border border-border px-3 py-2 text-center text-sm font-medium text-foreground transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40">Atur assignment & jadwal</summary><div class="mt-3 border-t border-border pt-3"><x-dispatch.schedule-form :work-order="$workOrder" :technicians="$technicians" :selected-date="$selectedDate" :filters="$filters" /></div></details>
            </article>
        @empty
            <p class="flex min-h-28 items-center justify-center rounded-control border border-dashed border-border p-4 text-center text-sm text-muted-foreground">Belum ada pekerjaan</p>
        @endforelse
    </div>
</section>