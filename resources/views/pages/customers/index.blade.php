<x-layouts::app.sidebar :title="__('Pelanggan')">
    <flux:main>
        <div class="mx-auto w-full max-w-[1520px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <flux:heading size="xl">Pelanggan</flux:heading>
                    <flux:subheading class="mt-1">Kelola akun pelanggan, lokasi, dan aset dalam satu alur kerja.</flux:subheading>
                </div>
                @can('create', [\App\Models\Customer::class, $organization])
                    <flux:button href="{{ route('customers.create') }}" variant="primary" icon="plus" wire:navigate>Tambah pelanggan</flux:button>
                @endcan
            </div>

            @if (session('status')) <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content">{{ session('status') }}</div> @endif

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-[minmax(0,1fr)_12rem_auto] sm:items-end">
                <div class="min-w-0">
                    <label for="customer-search" class="mb-2 block text-sm font-medium text-foreground">Cari pelanggan</label>
                    <input id="customer-search" name="q" value="{{ $search }}" placeholder="Nama, nomor, email, telepon" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" />
                </div>
                <div class="min-w-0">
                    <label for="customer-type" class="mb-2 block text-sm font-medium text-foreground">Jenis</label>
                    <select id="customer-type" name="type" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                        <option value="">Semua jenis</option>
                        <option value="business" @selected(request('type') === 'business')>Bisnis</option>
                        <option value="individual" @selected(request('type') === 'individual')>Perorangan</option>
                    </select>
                </div>
                <div class="flex flex-wrap gap-2">
                    <flux:button type="submit" variant="outline" icon="funnel">Terapkan</flux:button>
                    @if(request()->hasAny(['q', 'type'])) <flux:button href="{{ route('customers.index') }}" variant="ghost">Reset</flux:button> @endif
                </div>
            </form>

            <section class="lk-card overflow-hidden">
                <div class="flex flex-col gap-2 border-b border-border px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div><flux:heading size="lg">Daftar pelanggan</flux:heading><p class="mt-1 text-sm text-muted-foreground">{{ $customers->total() }} pelanggan terdaftar.</p></div>
                    <span class="text-xs text-muted-foreground">Filter tersimpan di URL</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[760px] w-full divide-y divide-border text-sm">
                        <thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th class="px-5 py-3 font-medium">Pelanggan</th><th class="px-5 py-3 font-medium">Kontak</th><th class="px-5 py-3 font-medium">Lokasi</th><th class="px-5 py-3 font-medium">Aset</th><th class="px-5 py-3 text-right font-medium">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-border">
                            @forelse($customers as $customer)
                                <tr class="transition hover:bg-surface-subtle/70">
                                    <td class="px-5 py-4"><a href="{{ route('customers.show', $customer) }}" class="font-semibold text-foreground hover:text-accent" wire:navigate>{{ $customer->name }}</a><p class="mt-1 text-xs text-muted-foreground">{{ $customer->customer_number }} · {{ $customer->customer_type === 'business' ? 'Bisnis' : 'Perorangan' }}</p></td>
                                    <td class="px-5 py-4 text-muted-foreground">{{ $customer->email ?: '—' }}<br>{{ $customer->phone ?: '—' }}</td>
                                    <td class="px-5 py-4 text-foreground">{{ $customer->sites_count }}</td>
                                    <td class="px-5 py-4 text-foreground">{{ $customer->assets_count }}</td>
                                    <td class="px-5 py-4 text-right"><flux:button href="{{ route('customers.edit', $customer) }}" variant="ghost" size="sm" icon="pencil-square" wire:navigate>Ubah</flux:button></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-5"><x-lk-empty-state icon="users" title="Belum ada pelanggan" description="Tambahkan pelanggan pertama untuk mulai membuat lokasi dan aset."><flux:button href="{{ route('customers.create') }}" variant="primary" wire:navigate>Tambah pelanggan</flux:button></x-lk-empty-state></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customers->hasPages()) <div class="border-t border-border px-5 py-4 sm:px-6">{{ $customers->links() }}</div> @endif
            </section>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
