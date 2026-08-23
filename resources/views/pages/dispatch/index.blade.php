<x-layouts::app.sidebar :title="__('Dispatch Board')">
    <flux:main>
        <div class="mx-auto w-full max-w-[1680px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 2xl:flex-row 2xl:items-end 2xl:justify-between">
                <div>
                    <p class="text-sm font-medium text-accent">Operasional · {{ $organization->name }}</p>
                    <flux:heading size="xl">Dispatch Board</flux:heading>
                    <flux:subheading class="mt-1">Atur kapasitas teknisi, jadwal, dan pekerjaan yang belum ditugaskan.</flux:subheading>
                </div>
                <div class="flex flex-wrap items-center gap-2" aria-label="Navigasi tanggal">
                    <flux:button href="{{ route('dispatch.index', array_merge(request()->query(), ['date' => $selectedDate->subDay()->toDateString()])) }}" variant="outline" icon="chevron-left" aria-label="Hari sebelumnya">Sebelumnya</flux:button>
                    <flux:button href="{{ route('dispatch.index', array_merge(request()->query(), ['date' => now($organization->timezone)->toDateString()])) }}" variant="ghost">Hari ini</flux:button>
                    <flux:button href="{{ route('dispatch.index', array_merge(request()->query(), ['date' => $selectedDate->addDay()->toDateString()])) }}" variant="outline" icon="chevron-right">Berikutnya</flux:button>
                </div>
            </div>

            @if(session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status" aria-live="polite">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="lk-card border-danger/30 bg-danger-soft p-4 text-sm text-danger-content" role="alert">
                    <p class="font-semibold">Jadwal belum disimpan.</p>
                    <ul class="mt-1 list-disc ps-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <section class="grid gap-3 sm:grid-cols-3" aria-label="Ringkasan agenda">
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Pekerjaan dalam rentang</p><p class="mt-2 text-3xl font-semibold text-foreground">{{ $summary['total'] }}</p></div>
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Belum ditugaskan</p><p class="mt-2 text-3xl font-semibold text-warning-content">{{ $summary['unassigned'] }}</p></div>
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Indikasi bentrok</p><p class="mt-2 text-3xl font-semibold text-danger-content">{{ $summary['conflicts'] }}</p></div>
            </section>

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-2 xl:grid-cols-[11rem_8rem_12rem_10rem_12rem_minmax(14rem,1fr)_auto] xl:items-end">
                <div>
                    <label for="dispatch-date" class="mb-2 block text-sm font-medium text-foreground">Tanggal</label>
                    <input id="dispatch-date" type="date" name="date" value="{{ $selectedDate->toDateString() }}" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div>
                    <label for="dispatch-view" class="mb-2 block text-sm font-medium text-foreground">Tampilan</label>
                    <select id="dispatch-view" name="view" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="day" @selected($view === 'day')>Hari</option><option value="week" @selected($view === 'week')>Minggu</option>
                    </select>
                </div>
                <div>
                    <label for="dispatch-technician" class="mb-2 block text-sm font-medium text-foreground">Teknisi</label>
                    <select id="dispatch-technician" name="technician_id" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua teknisi</option>
                        @foreach($technicians as $membership)<option value="{{ $membership->user_id }}" @selected((string) $filters['technician_id'] === (string) $membership->user_id)>{{ $membership->user->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label for="dispatch-status" class="mb-2 block text-sm font-medium text-foreground">Status</label>
                    <select id="dispatch-status" name="status" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua status</option>
                        @foreach(\App\Enums\WorkOrderStatus::cases() as $status)<option value="{{ $status->value }}" @selected($filters['status'] === $status->value)>{{ $status->label() }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label for="dispatch-priority" class="mb-2 block text-sm font-medium text-foreground">Prioritas</label>
                    <select id="dispatch-priority" name="priority" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua prioritas</option>
                        @foreach(\App\Enums\WorkOrderPriority::cases() as $priority)<option value="{{ $priority->value }}" @selected($filters['priority'] === $priority->value)>{{ $priority->label() }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label for="dispatch-area" class="mb-2 block text-sm font-medium text-foreground">Area</label>
                    <input id="dispatch-area" name="area" value="{{ $filters['area'] }}" placeholder="Kota atau provinsi" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div class="flex gap-2">
                    <div class="min-w-0 flex-1"><label for="dispatch-search" class="mb-2 block text-sm font-medium text-foreground">Cari</label><input id="dispatch-search" name="q" value="{{ $filters['q'] }}" placeholder="Nomor, judul, pelanggan" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30"></div>
                    <flux:button type="submit" variant="primary" icon="funnel" class="mt-7">Terapkan</flux:button>
                </div>
            </form>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div><flux:heading size="lg">{{ $view === 'week' ? 'Agenda minggu' : 'Agenda hari' }}</flux:heading><p class="mt-1 text-sm text-muted-foreground">{{ $from->format('d M Y') }}{{ $view === 'week' ? ' – '.$to->subDay()->format('d M Y') : '' }}</p></div>
                <a href="{{ route('work-orders.create') }}" class="inline-flex min-h-11 cursor-pointer items-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><flux:icon.plus class="size-4" />Buat work order</a>
            </div>

            <section class="hidden 2xl:block" aria-labelledby="dispatch-board-title">
                <h2 id="dispatch-board-title" class="sr-only">Board teknisi</h2>
                <div class="grid gap-4 xl:grid-cols-3 2xl:grid-cols-5">
                    <x-dispatch.lane title="Belum Ditugaskan" lane-key="unassigned" :work-orders="$lanes->get('unassigned', collect())" :technician="null" :technicians="$technicians" :filters="$filters" :selected-date="$selectedDate" />
                    @foreach($technicians as $membership)
                        <x-dispatch.lane :title="$membership->user->name" :lane-key="$membership->user_id" :work-orders="$lanes->get((string) $membership->user_id, collect())" :technician="$membership->user" :technicians="$technicians" :filters="$filters" :selected-date="$selectedDate" />
                    @endforeach
                </div>
            </section>

            <section class="2xl:hidden" aria-labelledby="dispatch-summary-title">
                <div class="lk-card p-4"><h2 id="dispatch-summary-title" class="font-semibold text-foreground">Ringkasan kapasitas teknisi</h2><p class="mt-1 text-sm text-muted-foreground">Gunakan daftar pekerjaan di bawah untuk membuka detail dan mengubah assignment.</p><div class="mt-4 grid gap-3 sm:grid-cols-2">@foreach($technicians as $membership)<a href="{{ route('dispatch.technicians.edit', array_merge(['user' => $membership->user_id], $filters, ['date' => $selectedDate->toDateString(), 'view' => $view])) }}" class="flex min-h-11 items-center gap-3 rounded-control border border-border p-3 transition hover:border-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><span class="size-3 rounded-full" style="background-color: {{ $membership->user->technicianProfile?->display_color ?? '#0284c7' }}"></span><span class="min-w-0 flex-1"><span class="block truncate font-medium text-foreground">{{ $membership->user->name }}</span><span class="text-xs text-muted-foreground">{{ $lanes->get((string) $membership->user_id, collect())->count() }} pekerjaan</span></span><flux:icon.chevron-right class="size-4 text-muted-foreground" /></a>@endforeach</div></div>
            </section>

            <section class="lk-card overflow-hidden" aria-labelledby="dispatch-list-title">
                <div class="flex flex-col gap-2 border-b border-border px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"><div><flux:heading size="lg" id="dispatch-list-title">Daftar aksesibel</flux:heading><p class="mt-1 text-sm text-muted-foreground">Alternatif board yang dapat dijalankan penuh dengan keyboard dan pembaca layar.</p></div><span class="text-xs text-muted-foreground">{{ $workOrders->count() }} pekerjaan</span></div>
                <div class="overflow-x-auto"><table class="min-w-[960px] w-full divide-y divide-border text-sm"><thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th class="px-5 py-3 font-medium">Work order</th><th class="px-5 py-3 font-medium">Jadwal</th><th class="px-5 py-3 font-medium">Teknisi</th><th class="px-5 py-3 font-medium">Lokasi</th><th class="px-5 py-3 font-medium">Status</th><th class="px-5 py-3 text-right font-medium">Aksi</th></tr></thead><tbody class="divide-y divide-border">
                    @forelse($workOrders as $workOrder)
                        <tr class="transition hover:bg-surface-subtle/70"><td class="px-5 py-4"><a href="{{ route('work-orders.show', $workOrder) }}?{{ http_build_query(['return_date' => $selectedDate->toDateString(), 'return_view' => $view, 'return_technician_id' => $filters['technician_id'], 'return_status' => $filters['status'], 'return_priority' => $filters['priority'], 'return_area' => $filters['area'], 'return_q' => $filters['q']]) }}" class="font-semibold text-foreground hover:text-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate>{{ $workOrder->number }}</a><p class="mt-1 max-w-[22rem] truncate text-muted-foreground">{{ $workOrder->title }}</p></td><td class="whitespace-nowrap px-5 py-4 text-muted-foreground">@if($workOrder->scheduled_start){{ $workOrder->scheduled_start->format('d M, H:i') }}–{{ $workOrder->scheduled_end?->format('H:i') }}@else Belum dijadwalkan @endif</td><td class="px-5 py-4">{{ $workOrder->primaryAssignment?->user?->name ?: 'Belum ditugaskan' }}@if((int) $workOrder->getAttribute('schedule_conflict_count') > 0)<span class="mt-1 block text-xs font-semibold text-danger-content" role="status">Bentrok: {{ $workOrder->getAttribute('schedule_conflict_count') }} jadwal</span>@endif</td><td class="px-5 py-4 text-muted-foreground">{{ $workOrder->site->city ?? $workOrder->site->name }}</td><td class="whitespace-nowrap px-5 py-4"><x-lk-status-badge :status="$workOrder->status->value" /><div class="mt-1"><x-lk-priority-badge :priority="$workOrder->priority->value" /></div></td><td class="whitespace-nowrap px-5 py-4 text-right"><details class="relative inline-block text-left"><summary class="inline-flex min-h-11 cursor-pointer list-none items-center gap-2 rounded-control border border-border px-3 text-sm font-medium text-foreground transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40">Atur jadwal <flux:icon.chevron-down class="size-4" /></summary><div class="absolute end-0 z-20 mt-2 w-[min(90vw,24rem)] rounded-card border border-border bg-surface p-4 text-start shadow-lg"><x-dispatch.schedule-form :work-order="$workOrder" :technicians="$technicians" :selected-date="$selectedDate" :filters="$filters" /></div></details></td></tr>
                    @empty<tr><td colspan="6" class="px-5 py-12 text-center text-sm text-muted-foreground">Tidak ada pekerjaan pada filter ini.</td></tr>@endforelse
                </tbody></table></div>
            </section>
        </div>
    </flux:main>
</x-layouts::app.sidebar>