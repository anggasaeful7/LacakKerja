<x-layouts::app.technician :title="__('Hari Ini')">
    <div class="space-y-6" data-offline-page="today">
        <header>
            <p class="text-sm font-medium text-accent">{{ $today->translatedFormat('l, d F Y') }}</p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-on-surface">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-base text-on-surface-variant">{{ $summary['total'] }} tugas di agenda hari ini · {{ $summary['active'] }} perlu perhatian.</p>
        </header>

        @if(session('status'))<div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status" aria-live="polite">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="lk-card border-danger/30 bg-danger-soft p-4 text-sm text-danger-content" role="alert"><p class="font-semibold">Aksi belum tersimpan.</p><ul class="mt-1 list-disc ps-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        @if($nextTask)
            <section aria-labelledby="next-task-title" class="space-y-3">
                <div class="flex items-center justify-between gap-3"><h2 id="next-task-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Tugas berikutnya</h2><x-lk-sync-badge status="synced" /></div>
                <article class="lk-panel border-s-accent p-5">
                    <div class="flex items-start justify-between gap-4"><div><x-lk-status-badge :status="$nextTask->status->value" /><p class="mt-3 lk-number text-xs font-semibold text-muted-foreground">{{ $nextTask->number }}</p></div><div class="text-end"><p class="lk-number text-3xl font-semibold text-on-surface">{{ $nextTask->scheduled_start?->format('H:i') ?: '—' }}</p><p class="text-sm font-medium text-on-surface-variant">{{ $nextTask->scheduled_start?->format('d M Y') ?: 'Waktu belum ditentukan' }}</p></div></div>
                    <h3 class="mt-4 text-xl font-semibold text-on-surface">{{ $nextTask->title }}</h3><div class="mt-4 flex items-start gap-3 text-sm text-on-surface-variant"><flux:icon.building-office-2 class="mt-0.5 size-5 shrink-0" /><div><p class="font-medium text-on-surface">{{ $nextTask->customer->name }}</p><p>{{ $nextTask->site->address_line1 }}, {{ $nextTask->site->city }}</p></div></div>
                    <div class="mt-5 grid grid-cols-[minmax(0,1fr)_auto] gap-3"><a href="{{ route('technician.work-orders.show', $nextTask) }}" class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate>Lihat tugas <flux:icon.arrow-right class="size-4" /></a><a href="{{ route('technician.work-orders.show', $nextTask) }}#location" class="inline-flex min-h-12 min-w-12 cursor-pointer items-center justify-center rounded-control border border-border text-on-surface transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40" aria-label="Buka detail lokasi"><flux:icon.map class="size-5" /></a></div>
                </article>
            </section>
        @else
            <section class="lk-panel p-6 text-center"><flux:icon.check-circle class="mx-auto size-10 text-success" /><h2 class="mt-3 text-lg font-semibold text-on-surface">Agenda hari ini kosong</h2><p class="mt-1 text-sm text-on-surface-variant">Nikmati waktu luang atau cek tugas yang akan datang.</p><flux:button class="mt-4 min-h-11" href="{{ route('technician.tasks', ['tab' => 'upcoming']) }}" variant="outline" wire:navigate>Lihat tugas berikutnya</flux:button></section>
        @endif

        <section aria-labelledby="today-summary-title" class="grid grid-cols-3 gap-2 sm:gap-3"><h2 id="today-summary-title" class="sr-only">Ringkasan hari ini</h2><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Total</p><p class="mt-1 text-2xl font-semibold text-on-surface">{{ $summary['total'] }}</p></div><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Aktif</p><p class="mt-1 text-2xl font-semibold text-accent">{{ $summary['active'] }}</p></div><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Selesai</p><p class="mt-1 text-2xl font-semibold text-success">{{ $summary['completed'] }}</p></div></section>

        <section aria-labelledby="agenda-title" class="space-y-3"><div class="flex items-center justify-between gap-3"><h2 id="agenda-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Agenda hari ini</h2><a href="{{ route('technician.tasks') }}" class="min-h-11 inline-flex items-center text-sm font-semibold text-accent hover:underline" wire:navigate>Lihat semua</a></div><div class="space-y-3">@forelse($todayTasks as $workOrder)<x-technician.task-card :work-order="$workOrder" />@empty<p class="rounded-card border border-dashed border-border p-6 text-center text-sm text-muted-foreground">Belum ada tugas untuk hari ini.</p>@endforelse</div></section>

        @if($upcomingTasks->isNotEmpty())<section aria-labelledby="upcoming-title" class="space-y-3"><h2 id="upcoming-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Akan datang</h2><div class="space-y-3">@foreach($upcomingTasks as $workOrder)<x-technician.task-card :work-order="$workOrder" compact />@endforeach</div></section>@endif
    </div>
</x-layouts::app.technician>