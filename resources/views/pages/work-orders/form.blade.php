@php
    $editing = $workOrder->exists;
    $selectedTechnician = old('technician_id', $workOrder->primaryAssignment?->user_id);
    $selectedCustomer = (int) old('customer_id', $workOrder->customer_id);
    $selectedSite = (int) old('customer_site_id', $workOrder->customer_site_id);
    $selectedAsset = (int) old('asset_id', $workOrder->asset_id);
    $selectedService = (int) old('service_id', $workOrder->service_id);
@endphp
<x-layouts::app.sidebar :title="$editing ? __('Ubah work order') : __('Buat work order')">
    <flux:main>
        <div class="mx-auto w-full max-w-5xl space-y-6 p-4 sm:p-6 lg:p-8">
            <div>
                <flux:button href="{{ $editing ? route('work-orders.show', $workOrder) : route('work-orders.index') }}" variant="ghost" icon="arrow-left" wire:navigate>Kembali ke work order</flux:button>
                <flux:heading size="xl" class="mt-3">{{ $editing ? 'Ubah work order' : 'Buat work order' }}</flux:heading>
                <flux:subheading class="mt-1">{{ $editing ? $workOrder->number.' · Perbarui detail pekerjaan yang belum terkunci.' : 'Isi detail inti pekerjaan. Jadwal dan teknisi dapat ditambahkan sekarang atau nanti.' }}</flux:subheading>
            </div>

            <form method="POST" action="{{ $editing ? route('work-orders.update', $workOrder) : route('work-orders.store') }}" class="space-y-6">
                @csrf
                @if($editing) @method('PUT') @endif
                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <flux:heading size="lg">Identitas pekerjaan</flux:heading>
                        <p class="mt-1 text-sm text-muted-foreground">Hubungkan pekerjaan ke customer, site, aset, dan layanan.</p>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="title" class="mb-2 block text-sm font-medium text-foreground">Ringkasan masalah <span class="text-danger">*</span></label>
                            <input id="title" name="title" value="{{ old('title', $workOrder->title) }}" required placeholder="Contoh: AC lantai 12 tidak dingin" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            @error('title')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="customer_id" class="mb-2 block text-sm font-medium text-foreground">Pelanggan <span class="text-danger">*</span></label>
                            <select id="customer_id" name="customer_id" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih pelanggan</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected($selectedCustomer === $customer->id)>{{ $customer->name }} · {{ $customer->customer_number }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="customer_site_id" class="mb-2 block text-sm font-medium text-foreground">Lokasi / site <span class="text-danger">*</span></label>
                            <select id="customer_site_id" name="customer_site_id" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih site</option>
                                @foreach($customers as $customer)
                                    @foreach($customer->sites as $site)
                                        <option value="{{ $site->id }}" @selected($selectedSite === $site->id)>{{ $customer->name }} · {{ $site->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('customer_site_id')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="asset_id" class="mb-2 block text-sm font-medium text-foreground">Aset</label>
                            <select id="asset_id" name="asset_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Tanpa aset spesifik</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}" @selected($selectedAsset === $asset->id)>{{ $asset->asset_identifier }} · {{ $asset->name }} · {{ $asset->customer->name }}</option>
                                @endforeach
                            </select>
                            @error('asset_id')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="service_id" class="mb-2 block text-sm font-medium text-foreground">Layanan</label>
                            <select id="service_id" name="service_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih bila memakai katalog layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" @selected($selectedService === $service->id)>{{ $service->name }} · {{ number_format((float) $service->base_price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            @error('service_id')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="priority" class="mb-2 block text-sm font-medium text-foreground">Prioritas <span class="text-danger">*</span></label>
                            <select id="priority" name="priority" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                @foreach(\App\Enums\WorkOrderPriority::cases() as $priority)
                                    <option value="{{ $priority->value }}" @selected(old('priority', $workOrder->priority?->value ?? 'normal') === $priority->value)>{{ $priority->label() }}</option>
                                @endforeach
                            </select>
                            @error('priority')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="estimated_total" class="mb-2 block text-sm font-medium text-foreground">Estimasi biaya (IDR)</label>
                            <input id="estimated_total" name="estimated_total" type="number" min="0" step="1" value="{{ old('estimated_total', $workOrder->estimated_total ?? 0) }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            @error('estimated_total')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                    </div>
                </section>

                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <flux:heading size="lg">Jadwal dan penugasan</flux:heading>
                        <p class="mt-1 text-sm text-muted-foreground">Work order akan tetap draft jika jadwal atau teknisi belum lengkap.</p>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-3">
                        <div>
                            <label for="scheduled_start" class="mb-2 block text-sm font-medium text-foreground">Mulai terjadwal</label>
                            <input id="scheduled_start" name="scheduled_start" type="datetime-local" value="{{ old('scheduled_start', $workOrder->scheduled_start?->format('Y-m-d\TH:i')) }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            @error('scheduled_start')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="scheduled_end" class="mb-2 block text-sm font-medium text-foreground">Selesai terjadwal</label>
                            <input id="scheduled_end" name="scheduled_end" type="datetime-local" value="{{ old('scheduled_end', $workOrder->scheduled_end?->format('Y-m-d\TH:i')) }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            @error('scheduled_end')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                        <div>
                            <label for="technician_id" class="mb-2 block text-sm font-medium text-foreground">Teknisi utama</label>
                            <select id="technician_id" name="technician_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Belum ditugaskan</option>
                                @foreach($technicians as $membership)
                                    <option value="{{ $membership->user_id }}" @selected((int) $selectedTechnician === (int) $membership->user_id)>{{ $membership->user->name }}</option>
                                @endforeach
                            </select>
                            @error('technician_id')<flux:error>{{ $message }}</flux:error>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="sla_due_at" class="mb-2 block text-sm font-medium text-foreground">Batas SLA</label>
                        <input id="sla_due_at" name="sla_due_at" type="datetime-local" value="{{ old('sla_due_at', $workOrder->sla_due_at?->format('Y-m-d\TH:i')) }}" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                        @error('sla_due_at')<flux:error>{{ $message }}</flux:error>@enderror
                    </div>
                </section>

                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <flux:heading size="lg">Deskripsi dan instruksi</flux:heading>
                        <p class="mt-1 text-sm text-muted-foreground">Tuliskan konteks yang perlu diketahui dispatcher dan teknisi.</p>
                    </div>
                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-foreground">Deskripsi pekerjaan</label>
                        <textarea id="description" name="description" rows="5" class="w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground">{{ old('description', $workOrder->description) }}</textarea>
                        @error('description')<flux:error>{{ $message }}</flux:error>@enderror
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <flux:button href="{{ $editing ? route('work-orders.show', $workOrder) : route('work-orders.index') }}" variant="ghost" wire:navigate>Batal</flux:button>
                    <flux:button type="submit" variant="primary">{{ $editing ? 'Simpan perubahan' : 'Buat work order' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>