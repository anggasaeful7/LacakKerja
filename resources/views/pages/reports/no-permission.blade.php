<x-layouts::app.sidebar :title="__('Laporan')">
    <flux:main class="min-w-0 p-4 sm:p-6 lg:p-8">
        <div id="main-content" class="mx-auto w-full max-w-4xl">
            <section class="lk-panel flex flex-col items-start gap-4 p-6 sm:p-8" role="alert">
                <span class="flex size-12 items-center justify-center rounded-full bg-warning-soft text-warning"><flux:icon.lock-closed class="size-6" /></span>
                <h1 class="text-2xl font-semibold text-on-surface">Laporan terbatas</h1>
                <p class="max-w-xl text-sm leading-6 text-on-surface-variant">Laporan operasional dan keuangan hanya tersedia untuk Owner, Admin, dan Dispatcher pada organisasi {{ $organization->name }}.</p>
                <flux:button href="{{ route('dashboard') }}" variant="primary" icon="arrow-left" class="min-h-11">Kembali ke dashboard</flux:button>
            </section>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
