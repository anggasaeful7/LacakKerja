@props([
    'priority' => 'normal',
])

@php
    $labels = [
        'low' => 'Rendah',
        'normal' => 'Normal',
        'high' => 'Tinggi',
        'urgent' => 'Urgent',
    ];
    $colors = [
        'low' => 'zinc',
        'normal' => 'blue',
        'high' => 'orange',
        'urgent' => 'red',
    ];
@endphp

<flux:badge :color="$colors[$priority] ?? 'zinc'" icon="exclamation-triangle" size="sm" {{ $attributes }}>{{ $labels[$priority] ?? str($priority)->headline() }}</flux:badge>