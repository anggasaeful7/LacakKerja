<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="theme-color" content="#0F172A" />
<meta name="color-scheme" content="light dark" /><meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="manifest" href="/manifest.webmanifest">
<meta name="lk-currency" content="{{ request()->attributes->get('currentOrganization')?->currency ?? 'IDR' }}">
@if(auth()->check())
    <meta name="lk-scope" content="{{ auth()->id() }}:{{ auth()->user()->current_organization_id }}">
    <meta name="lk-sync-bootstrap-url" content="{{ route('technician.sync.bootstrap') }}">
    <meta name="lk-sync-batch-url" content="{{ route('technician.sync.batch') }}">
@endif

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'LacakKerja') : config('app.name', 'LacakKerja') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance