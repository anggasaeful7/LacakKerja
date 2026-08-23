@props([
    'status' => 'draft',
    'label' => null,
])

@php
    $labels = [
        'draft' => 'Draft',
        'scheduled' => 'Terjadwal',
        'dispatched' => 'Dikirim',
        'en_route' => 'Dalam perjalanan',
        'in_progress' => 'Sedang dikerjakan',
        'on_hold' => 'Ditunda',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
    $colors = [
        'draft' => 'zinc',
        'scheduled' => 'blue',
        'dispatched' => 'indigo',
        'en_route' => 'violet',
        'in_progress' => 'amber',
        'on_hold' => 'orange',
        'completed' => 'green',
        'cancelled' => 'red',
    ];
    $icons = [
        'draft' => 'document',
        'scheduled' => 'calendar-days',
        'dispatched' => 'paper-airplane',
        'en_route' => 'map-pin',
        'in_progress' => 'wrench-screwdriver',
        'on_hold' => 'pause',
        'completed' => 'check-circle',
        'cancelled' => 'x-circle',
    ];
@endphp

<flux:badge
    :color="$colors[$status] ?? 'zinc'"
    :icon="$icons[$status] ?? 'document'"
    size="sm"
    {{ $attributes }}
>{{ $label ?? ($labels[$status] ?? str($status)->headline()) }}</flux:badge>