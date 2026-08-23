@props([
    'status' => 'synced',
])

@php
    $labels = [
        'synced' => 'Tersinkronisasi',
        'syncing' => 'Menyinkronkan',
        'offline' => 'Offline · tersimpan lokal',
        'failed' => 'Sinkronisasi gagal',
    ];
    $colors = [
        'synced' => 'green',
        'syncing' => 'blue',
        'offline' => 'amber',
        'failed' => 'red',
    ];
    $icons = [
        'synced' => 'cloud',
        'syncing' => 'arrow-path',
        'offline' => 'signal-slash',
        'failed' => 'exclamation-triangle',
    ];
@endphp

<flux:badge :color="$colors[$status] ?? 'zinc'" :icon="$icons[$status] ?? 'cloud'" rounded size="sm" {{ $attributes }}>{{ $labels[$status] ?? str($status)->headline() }}</flux:badge>