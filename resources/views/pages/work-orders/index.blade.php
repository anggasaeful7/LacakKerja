<x-layouts::app.sidebar :title="__('Work order')">
    <flux:main>
        <div class="mx-auto w-full max-w-[1520px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <flux:heading size="xl">Work order</flux:heading>
                    <flux:subheading class="mt-1">Kelola pekerjaan lapangan, jadwal, prioritas, dan progres teknisi.</flux:subheading>
                </div>
                @can('create', [\App\Models\WorkOrder::class, $organization])
                    <flux:button href="{{ route('work-orders.create') }}" variant="primary" icon="plus" wire:navigate>Buat work order</flux:button>
                @endcan
            </div>

            @if(session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status">{{ session('status') }}</div>
            @endif

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-[minmax(0,1fr)_12rem_12rem_10rem_auto] sm:items-end">
                <div class="min-w-0">
                    <label for="work-order-search" class="mb-2 block text-sm font-medium text-foreground">Cari work order</label>
                    <input id="work-order-search" name="q" value="{{ $search }}" placeholder="Nomor, judul, pelanggan" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                </div>
                <div class="min-w-0">
                    <label for="work-order-status" class="mb-2 block text-sm font-medium text-foreground">Status</label>
                    <select id="work-order-status" name="status" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                        <option value="">Semua status</option>
                        @foreach(\App\Enums\WorkOrderStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-0">
                    <label for="work-order-priority" class="mb-2 block text-sm font-medium text-foreground">Prioritas</label>
                    <select id="work-order-priority" name="priority" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                        <option value="">Semua prioritas</option>
                        @foreach(\App\Enums\WorkOrderPriority::cases() as $priority)
                            <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>{{ $priority->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-0">
                    <label for="work-order-date" class="mb-2 block text-sm font-medium text-foreground">Tanggal</label>
                    <input id="work-order-date" type="date" name="date" value="{{ request('date') }}" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                </div>
                <div class="flex flex-wrap gap-2">
                    <flux:button type="submit" variant="outline" icon="funnel">Terapkan</flux:button>
                    @if(request()->hasAny(['q', 'status', 'priority', 'date']))
                        <flux:button href="{{ route('work-orders.index') }}" variant="ghost" wire:navigate>Reset</flux:button>
                    @endif
                </div>
            </form>

            <section class="lk-card overflow-hidden">
                <div class="flex flex-col gap-2 border-b border-border px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <flux:heading size="lg">Daftar pekerjaan</flux:heading>
                        <p class="mt-1 text-sm text-muted-foreground">{{ $workOrders->total() }} work order.</p>
                    </div>
                    <span class="text-xs text-muted-foreground">Filter tersimpan di URL</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[1120px] w-full divide-y divide-border text-sm">
                        <thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground">
                            <tr>
                                <th class="px-5 py-3 font-medium">Work order</th>
                                <th class="px-5 py-3 font-medium">Pelanggan / lokasi</th>
                                <th class="whitespace-nowrap px-5 py-3 font-medium">Jadwal</th>
                                <th class="whitespace-nowrap px-5 py-3 font-medium">Teknisi</th>
                                <th class="whitespace-nowrap px-5 py-3 font-medium">Prioritas</th>
                                <th class="whitespace-nowrap px-5 py-3 font-medium">Status</th>
                                <th class="whitespace-nowrap px-5 py-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($workOrders as $workOrder)
                                <tr class="transition hover:bg-surface-subtle/70">
                                    <td class="px-5 py-4">
                                        <a href="{{ route('work-orders.show', $workOrder) }}" class="font-semibold text-foreground hover:text-accent" wire:navigate>{{ $workOrder->number }}</a>
                                        <p class="mt-1 max-w-[18rem] truncate text-sm text-muted-foreground">{{ $workOrder->title }}</p>
                                        @if($workOrder->service)
                                            <p class="mt-1 text-xs text-muted-foreground">{{ $workOrder->service->name }}</p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-muted-foreground">
                                        <span class="font-medium text-foreground">{{ $workOrder->customer->name }}</span>
                                        <br>{{ $workOrder->site->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-muted-foreground">
                                        @if($workOrder->scheduled_start)
                                            <span class="text-foreground">{{ $workOrder->scheduled_start->format('d M Y') }}</span>
                                            <br>{{ $workOrder->scheduled_start->format('H:i') }}–{{ $workOrder->scheduled_end?->format('H:i') }}
                                        @else
                                            Belum dijadwalkan
                                        @endif
                                        @if($workOrder->isOverdue())
                                            <span class="mt-1 block text-xs font-medium text-danger">Lewat SLA</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-muted-foreground">{{ $workOrder->primaryAssignment?->user?->name ?: 'Belum ditugaskan' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4"><x-lk-priority-badge :priority="$workOrder->priority->value" /></td>
                                    <td class="whitespace-nowrap px-5 py-4"><x-lk-status-badge :status="$workOrder->status->value" /></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        <flux:button href="{{ route('work-orders.show', $workOrder) }}" variant="ghost" size="sm" icon="arrow-right" wire:navigate>Lihat</flux:button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6">
                                        <x-lk-empty-state icon="clipboard-document-list" title="Belum ada work order" description="Buat pekerjaan pertama untuk mulai mengatur jadwal dan progres teknisi.">
                                            @can('create', [\App\Models\WorkOrder::class, $organization])
                                                <flux:button href="{{ route('work-orders.create') }}" variant="primary" wire:navigate>Buat work order</flux:button>
                                            @endcan
                                        </x-lk-empty-state>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($workOrders->hasPages())
                    <div class="border-t border-border px-5 py-4 sm:px-6">{{ $workOrders->links() }}</div>
                @endif
            </section>
        </div>
    </flux:main>
</x-layouts::app.sidebar>