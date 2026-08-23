@props([
    'title',
    'description' => null,
    'icon' => 'clipboard-document-list',
])

<div {{ $attributes->class('flex min-h-48 flex-col items-center justify-center rounded-panel border border-dashed border-border-strong bg-surface px-6 py-10 text-center') }}>
    <span class="inline-flex size-12 items-center justify-center rounded-full bg-accent-soft text-accent" aria-hidden="true">
        <flux:icon :name="$icon" class="size-6" />
    </span>
    <h3 class="mt-4 text-base font-semibold text-on-surface">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 max-w-sm text-sm text-on-surface-variant">{{ $description }}</p>
    @endif
    @if($slot->isNotEmpty())
        <div class="mt-5">{{ $slot }}</div>
    @endif
</div>