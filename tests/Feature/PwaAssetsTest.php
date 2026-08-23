<?php

it('keeps PWA shell configured for offline technician use', function () {
    $manifestJson = file_get_contents(public_path('manifest.webmanifest'));
    expect($manifestJson)->not->toBeFalse();

    $manifest = json_decode((string) $manifestJson, true, 512, JSON_THROW_ON_ERROR);

    expect($manifest)
        ->toMatchArray([
            'start_url' => '/technician/today',
            'scope' => '/',
            'display' => 'standalone',
        ]);

    $serviceWorker = file_get_contents(public_path('sw.js'));
    expect($serviceWorker)->not->toBeFalse();

    expect((string) $serviceWorker)
        ->toContain("const VERSION = 'lacakkerja-shell-v2';")
        ->toContain("const TECHNICIAN_PAGE_PREFIX = '/technician/work-orders/';")
        ->toContain('CLEAR_TECHNICIAN_PAGES');
});
