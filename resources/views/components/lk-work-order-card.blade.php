@props([
    'number',
    'title',
    'customer',
    'schedule',
    'status' => 'scheduled',
    'priority' => 'normal',
    'location' => null,
])

<a href="#" aria-label="{{ $number }} — {{ $title }}" {{ $attributes->class('lk-clickable block rounded-card border border-border bg-surface p-4') }}>
    <div class="flex items-start justify-between gap-3">
        <span class="lk-number text-xs font-semibold tracking-wide text-muted-foreground">{{ $number }}</span>
        <x-lk-priority-badge :priority="$priority" />
    </div>
    <h3 class="mt-3 text-base font-semibold text-on-surface">{{ $title }}</h3>
    <p class="mt-1 text-sm text-on-surface-variant">{{ $customer }}</p>
    <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs text-muted-foreground">
        <span class="inline-flex items-center gap-1.5"><flux:icon.clock class="size-4" />{{ $schedule }}</span>
        @if($location)
            <span class="inline-flex items-center gap-1.5"><flux:icon.map-pin class="size-4" />{{ $location }}</span>
        @endif
    </div>
    <div class="mt-4 border-t border-border pt-3">
        <x-lk-status-badge :status="$status" />
    </div>
</a>