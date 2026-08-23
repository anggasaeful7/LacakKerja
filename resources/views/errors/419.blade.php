<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>419 · LacakKerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-background text-foreground">
    <main class="mx-auto flex min-h-dvh max-w-xl flex-col items-center justify-center px-6 py-16 text-center" aria-labelledby="error-title">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-accent">419</p>
        <h1 id="error-title" class="mt-3 font-display text-4xl text-on-surface">Sesi kedaluwarsa</h1>
        <p class="mt-4 max-w-prose text-on-surface-variant">Form ini sudah tidak berlaku. Muat ulang halaman lalu coba lagi.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-control border border-border px-4 text-sm font-semibold text-on-surface hover:bg-surface-subtle focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">Kembali ke beranda</a>
            <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-control bg-accent px-4 text-sm font-semibold text-white hover:bg-accent-hover focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">Ke beranda</a>
        </div>
    </main>
</body>
</html>