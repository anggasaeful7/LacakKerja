@props([
    'label',
    'value',
    'detail' => null,
    'icon' => 'chart-bar',
    'tone' => 'neutral',
])

@php
    $toneClasses = [
        'neutral' => 'bg-surface-subtle text-secondary',
        'info' => 'bg-info-soft text-info',
        'success' => 'bg-success-soft text-success',
        'warning' => 'bg-warning-soft text-warning',
        'danger' => 'bg-danger-soft text-danger',
    ];
@endphp

<div {{ $attributes->class('lk-card flex min-h-36 flex-col justify-between p-5') }}>
    <div class="flex items-start justify-between gap-4">
        <p class="text-sm font-medium text-on-surface-variant">{{ $label }}</p>
        <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-control {{ $toneClasses[$tone] ?? $toneClasses['neutral'] }}" aria-hidden="true">
            <flux:icon :name="$icon" class="size-5" />
        </span>
    </div>
    <div class="mt-5 flex items-end justify-between gap-3">
        <p class="lk-number text-3xl font-semibold tracking-tight text-on-surface">{{ $value }}</p>
        @if($detail)
            <p class="text-xs font-medium text-on-surface-variant">{{ $detail }}</p>
        @endif
    </div>
</div>