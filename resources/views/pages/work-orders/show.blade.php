@php
    $currentStatus = $workOrder->status;
    $hasActiveTime = $workOrder->timeLogs->contains(fn ($log) => $log->isActive());
    $returnQuery = collect(['date', 'view', 'technician_id', 'status', 'priority', 'area', 'q'])->mapWithKeys(fn (string $key): array => [$key => request('return_'.$key)])->filter(fn (mixed $value): bool => filled($value))->all();
    $backUrl = request()->filled('return_date') ? route('dispatch.index', $returnQuery) : route('work-orders.index');
    $backLabel = request()->filled('return_date') ? 'Kembali ke dispatch' : 'Semua work order';
@endphp
<x-layouts::app.sidebar :title="$workOrder->number">
    <flux:main>
        <div class="mx-auto w-full max-w-[1520px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="min-w-0">
                    <flux:button href="{{ $backUrl }}" variant="ghost" icon="arrow-left" wire:navigate>{{ $backLabel }}</flux:button>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <flux:heading size="xl">{{ $workOrder->number }}</flux:heading>
                        <x-lk-status-badge :status="$workOrder->status->value" />
                        <x-lk-priority-badge :priority="$workOrder->priority->value" />
                    </div>
                    <flux:subheading class="mt-1 max-w-3xl">{{ $workOrder->title }}</flux:subheading>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($canManage && ! $workOrder->isLocked())
                        <flux:button href="{{ route('work-orders.edit', $workOrder) }}" variant="outline" icon="pencil-square" wire:navigate>Ubah</flux:button>
                    @endif
                    @if($canManage && $workOrder->status === \App\Enums\WorkOrderStatus::Completed)
                        @php $activeInvoice = $workOrder->invoices->first(fn ($invoice) => $invoice->status !== \App\Enums\InvoiceStatus::Void); @endphp
                        @if($activeInvoice)
                            <flux:button href="{{ route('invoices.show', $activeInvoice) }}" variant="outline" icon="banknotes" wire:navigate>Lihat invoice</flux:button>
                        @else
                            <flux:button href="{{ route('invoices.create', ['work_order_id' => $workOrder->id]) }}" variant="primary" icon="banknotes" wire:navigate>Buat invoice</flux:button>
                        @endif
                    @endif
                    @if($workOrder->isOverdue())
                        <span class="inline-flex min-h-10 items-center rounded-control bg-danger-soft px-3 text-sm font-medium text-danger">Lewat SLA</span>
                    @endif
                </div>
            </div>

            @if(session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="lk-card border-danger/30 bg-danger-soft p-4 text-sm text-danger" role="alert">
                    <p class="font-semibold">Perlu diperiksa</p>
                    <ul class="mt-2 list-disc space-y-1 ps-5 text-sm">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @if($canTransition && ! $workOrder->isLocked())
                <section class="lk-card p-5 sm:p-6" aria-labelledby="status-actions-title">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <flux:heading size="lg" id="status-actions-title">Aksi status</flux:heading>
                            <p class="mt-1 text-sm text-muted-foreground">Semua perubahan status divalidasi server dan tercatat pada activity.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($currentStatus->allowedTransitions() as $target)
                                @php
                                    $reasonNeeded = $target === \App\Enums\WorkOrderStatus::OnHold || $target === \App\Enums\WorkOrderStatus::Cancelled || ($currentStatus === \App\Enums\WorkOrderStatus::Completed && $target === \App\Enums\WorkOrderStatus::InProgress);
                                @endphp
                                <form method="POST" action="{{ $target === \App\Enums\WorkOrderStatus::Completed ? route('work-orders.complete', $workOrder) : route('work-orders.transition', $workOrder) }}" class="flex flex-wrap items-end gap-2">
                                    @csrf
                                    @if($target !== \App\Enums\WorkOrderStatus::Completed)
                                        <input type="hidden" name="status" value="{{ $target->value }}">
                                    @endif
                                    @if($reasonNeeded)
                                        <label class="sr-only" for="reason-{{ $target->value }}">Alasan</label>
                                        <input id="reason-{{ $target->value }}" name="reason" required placeholder="Alasan {{ strtolower($target->label()) }}" class="h-10 w-44 rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                    @endif
                                    <flux:button type="submit" variant="{{ $target === \App\Enums\WorkOrderStatus::Cancelled ? 'ghost' : ($target === \App\Enums\WorkOrderStatus::Completed ? 'primary' : 'outline') }}" icon="{{ $target === \App\Enums\WorkOrderStatus::Completed ? 'check-circle' : 'arrow-right' }}">{{ $target->label() }}</flux:button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan work order">
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Pelanggan</p><p class="mt-2 font-semibold text-foreground">{{ $workOrder->customer->name }}</p><p class="mt-1 text-sm text-muted-foreground">{{ $workOrder->site->name }}</p></div>
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Teknisi utama</p><p class="mt-2 font-semibold text-foreground">{{ $workOrder->primaryAssignment?->user?->name ?: 'Belum ditugaskan' }}</p><p class="mt-1 text-sm text-muted-foreground">{{ $workOrder->service?->name ?: 'Layanan manual' }}</p></div>
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Jadwal</p><p class="mt-2 font-semibold text-foreground">{{ $workOrder->scheduled_start?->format('d M Y') ?: 'Belum dijadwalkan' }}</p><p class="mt-1 text-sm text-muted-foreground">{{ $workOrder->scheduled_start?->format('H:i').'–'.$workOrder->scheduled_end?->format('H:i') ?: 'Atur jadwal untuk dispatch' }}</p></div>
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Estimasi biaya</p><p class="mt-2 font-semibold text-foreground">Rp {{ number_format($workOrder->estimated_total, 0, ',', '.') }}</p><p class="mt-1 text-sm text-muted-foreground">Lock version {{ $workOrder->lock_version }}</p></div>
            </section>

            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
                <div class="space-y-6">
                    <section class="lk-card overflow-hidden" aria-labelledby="description-title">
                        <div class="border-b border-border px-5 py-4 sm:px-6"><flux:heading size="lg" id="description-title">Detail pekerjaan</flux:heading></div>
                        <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">
                            <div class="sm:col-span-2"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Deskripsi</p><p class="mt-2 whitespace-pre-line text-sm leading-6 text-foreground">{{ $workOrder->description ?: 'Belum ada deskripsi tambahan.' }}</p></div>
                            <div><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Aset</p><p class="mt-2 text-sm font-medium text-foreground">{{ $workOrder->asset?->name ?: 'Tanpa aset spesifik' }}</p><p class="mt-1 text-xs text-muted-foreground">{{ $workOrder->asset?->asset_identifier ?: '—' }}</p></div>
                            <div><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Dibuat oleh</p><p class="mt-2 text-sm font-medium text-foreground">{{ $workOrder->creator?->name ?: 'System' }}</p><p class="mt-1 text-xs text-muted-foreground">{{ $workOrder->created_at?->format('d M Y H:i') }}</p></div>
                        </div>
                    </section>

                    <section class="lk-card overflow-hidden" aria-labelledby="checklist-title">
                        <div class="flex flex-col gap-2 border-b border-border px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div><flux:heading size="lg" id="checklist-title">Checklist pekerjaan</flux:heading><p class="mt-1 text-sm text-muted-foreground">{{ $workOrder->checklistItems->where('is_required', true)->whereNotNull('value')->count() }} dari {{ $workOrder->checklistItems->where('is_required', true)->count() }} item wajib selesai.</p></div>
                            <span class="text-xs text-muted-foreground">Snapshot saat work order dibuat</span>
                        </div>
                        <div class="divide-y divide-border">
                            @forelse($workOrder->checklistItems as $item)
                                @php $currentValue = $item->value['value'] ?? null; @endphp
                                <form method="POST" action="{{ route('work-orders.checklist.update', [$workOrder, $item]) }}" class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-start sm:justify-between sm:px-6">
                                    @csrf @method('PATCH')
                                    <div class="min-w-0">
                                        <p class="font-medium text-foreground">{{ $item->sort_order }}. {{ $item->label }} @if($item->is_required)<span class="text-danger">*</span>@endif</p>
                                        @if($item->photo_required)<p class="mt-1 text-xs text-warning">Foto bukti diperlukan</p>@endif
                                        @if($item->input_type === \App\Enums\ChecklistInputType::Choice && $item->options)
                                            <select name="value" class="mt-3 h-10 w-full min-w-48 rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                                <option value="">Belum dijawab</option>
                                                @foreach($item->options as $option)<option value="{{ $option }}" @selected((string) $currentValue === (string) $option)>{{ $option }}</option>@endforeach
                                            </select>
                                        @elseif($item->input_type === \App\Enums\ChecklistInputType::Number)
                                            <input name="value" type="number" value="{{ $currentValue }}" placeholder="Masukkan angka" class="mt-3 h-10 w-full min-w-48 rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                        @elseif($item->input_type === \App\Enums\ChecklistInputType::Text)
                                            <input name="value" value="{{ $currentValue }}" placeholder="Jawaban teknisi" class="mt-3 h-10 w-full min-w-48 rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                        @else
                                            <label class="mt-3 inline-flex min-h-10 items-center gap-3 text-sm text-foreground"><input type="hidden" name="value" value="0"><input type="checkbox" name="value" value="1" @checked((string) $currentValue === '1') class="size-4 rounded border-border text-accent focus:ring-accent">Sudah diperiksa</label>
                                        @endif
                                    </div>
                                    <div class="flex shrink-0 items-center gap-3">
                                        @if($item->completed_at)<span class="text-xs text-success-content">Dijawab {{ $item->completed_at->format('d M H:i') }}</span>@endif
                                        <flux:button type="submit" variant="outline" size="sm">Simpan</flux:button>
                                    </div>
                                </form>
                            @empty
                                <div class="p-6"><x-lk-empty-state icon="clipboard-document-check" title="Tidak ada checklist" description="Pilih layanan dengan template published untuk menyalin checklist ke work order." /></div>
                            @endforelse
                        </div>
                    </section>

                    <section class="lk-card overflow-hidden" aria-labelledby="notes-title">
                        <div class="border-b border-border px-5 py-4 sm:px-6"><flux:heading size="lg" id="notes-title">Catatan</flux:heading><p class="mt-1 text-sm text-muted-foreground">Catatan internal atau yang dapat dilihat pelanggan.</p></div>
                        <div class="divide-y divide-border">
                            @forelse($workOrder->notes as $note)
                                <article class="px-5 py-4 sm:px-6"><div class="flex flex-wrap items-center gap-2"><span class="font-medium text-foreground">{{ $note->author?->name ?: 'System' }}</span><span class="text-xs text-muted-foreground">{{ $note->created_at?->format('d M Y H:i') }}</span><span class="rounded-full bg-surface-subtle px-2 py-0.5 text-xs text-muted-foreground">{{ $note->visibility->label() }}</span></div><p class="mt-2 whitespace-pre-line text-sm leading-6 text-foreground">{{ $note->body }}</p></article>
                            @empty
                                <div class="p-5"><x-lk-empty-state icon="chat-bubble-left-right" title="Belum ada catatan" description="Tambahkan catatan penyelesaian agar completion gate dapat terpenuhi." /></div>
                            @endforelse
                        </div>
                        @can('addNote', $workOrder)
                            <form method="POST" action="{{ route('work-orders.notes.store', $workOrder) }}" class="border-t border-border p-5 sm:p-6">
                                @csrf
                                <label for="note-body" class="mb-2 block text-sm font-medium text-foreground">Tambah catatan</label>
                                <textarea id="note-body" name="body" rows="3" required placeholder="Contoh: Unit sudah dibersihkan dan diuji selama 20 menit." class="w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground"></textarea>
                                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><select name="visibility" class="h-10 rounded-control border border-border bg-surface px-3 text-sm text-foreground"><option value="internal">Internal</option><option value="customer">Pelanggan</option></select><flux:button type="submit" variant="outline" icon="plus">Tambah catatan</flux:button></div>
                            </form>
                        @endcan
                    </section>

                    <section class="lk-card overflow-hidden" aria-labelledby="attachments-title">
                        <div class="border-b border-border px-5 py-4 sm:px-6"><flux:heading size="lg" id="attachments-title">File dan bukti</flux:heading><p class="mt-1 text-sm text-muted-foreground">File disimpan pada private disk dan hanya dapat diunduh oleh pengguna yang berhak.</p></div>
                        <div class="divide-y divide-border">
                            @forelse($workOrder->attachments as $attachment)
                                <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"><div class="flex min-w-0 items-center gap-3"><span class="flex size-9 shrink-0 items-center justify-center rounded-control bg-accent-soft text-accent"><flux:icon.paper-clip class="size-4" /></span><div class="min-w-0"><a href="{{ route('work-orders.attachments.download', [$workOrder, $attachment]) }}" class="truncate font-medium text-accent hover:underline">{{ $attachment->original_name }}</a><p class="mt-1 text-xs text-muted-foreground">{{ $attachment->category->label() }} · {{ number_format($attachment->size_bytes / 1024, 0) }} KB</p></div></div><span class="whitespace-nowrap text-xs text-muted-foreground">{{ $attachment->created_at?->format('d M Y H:i') }}</span></div>
                            @empty
                                <div class="p-5"><x-lk-empty-state icon="paper-clip" title="Belum ada file" description="Unggah foto sebelum, sesudah, atau bukti pekerjaan." /></div>
                            @endforelse
                        </div>
                        @can('attach', $workOrder)
                            @if(! $workOrder->isLocked())
                                <form method="POST" action="{{ route('work-orders.attachments.store', $workOrder) }}" enctype="multipart/form-data" class="grid gap-3 border-t border-border p-5 sm:grid-cols-[minmax(0,1fr)_10rem_auto] sm:items-end sm:p-6">
                                    @csrf
                                    <div><label for="attachment-file" class="mb-2 block text-sm font-medium text-foreground">Pilih file</label><input id="attachment-file" type="file" name="file" required accept=".jpg,.jpeg,.png,.webp,.pdf" class="block min-h-10 w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground"></div>
                                    <div><label for="attachment-category" class="mb-2 block text-sm font-medium text-foreground">Kategori</label><select id="attachment-category" name="category" class="h-10 w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground">@foreach(\App\Enums\AttachmentCategory::cases() as $category)<option value="{{ $category->value }}">{{ $category->label() }}</option>@endforeach</select></div>
                                    <flux:button type="submit" variant="outline" icon="arrow-up-tray">Upload</flux:button>
                                </form>
                            @endif
                        @endcan
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="lk-card p-5 sm:p-6" aria-labelledby="time-title">
                        <flux:heading size="lg" id="time-title">Time log</flux:heading>
                        <p class="mt-1 text-sm text-muted-foreground">Catat durasi kerja teknisi.</p>
                        @can('trackTime', $workOrder)
                            @if($currentStatus === \App\Enums\WorkOrderStatus::InProgress && ! $hasActiveTime)
                                <form method="POST" action="{{ route('work-orders.time.start', $workOrder) }}" class="mt-4">@csrf<flux:button type="submit" variant="primary" icon="play">Mulai timer</flux:button></form>
                            @endif
                        @endcan
                        <div class="mt-4 divide-y divide-border">
                            @forelse($workOrder->timeLogs as $timeLog)
                                <div class="py-3 first:pt-0"><div class="flex items-center justify-between gap-3"><span class="text-sm font-medium text-foreground">{{ $timeLog->user?->name }}</span>@if($timeLog->isActive())<span class="rounded-full bg-warning-soft px-2 py-0.5 text-xs font-medium text-warning">Aktif</span>@else<span class="text-xs text-muted-foreground">{{ $timeLog->duration_minutes }} menit</span>@endif</div><p class="mt-1 text-xs text-muted-foreground">{{ $timeLog->started_at->format('d M H:i') }}{{ $timeLog->ended_at ? '–'.$timeLog->ended_at->format('H:i') : '' }}</p>@if($timeLog->isActive() && ($timeLog->user_id === auth()->id() || $canManage))<form method="POST" action="{{ route('work-orders.time.stop', [$workOrder, $timeLog]) }}" class="mt-2">@csrf<flux:button type="submit" size="sm" variant="outline">Hentikan</flux:button></form>@endif</div>
                            @empty
                                <p class="py-3 text-sm text-muted-foreground">Belum ada time log.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="lk-card p-5 sm:p-6" aria-labelledby="activity-title">
                        <flux:heading size="lg" id="activity-title">Activity status</flux:heading>
                        <div class="mt-4 divide-y divide-border">
                            @forelse($workOrder->statusHistories as $history)
                                <div class="py-3 first:pt-0"><div class="flex items-center justify-between gap-3"><x-lk-status-badge :status="$history->to_status->value" /><span class="text-xs text-muted-foreground">{{ $history->created_at?->format('d M H:i') }}</span></div><p class="mt-1 text-xs text-muted-foreground">{{ $history->actor?->name ?: 'System' }}{{ $history->reason ? ' · '.$history->reason : '' }}</p></div>
                            @empty
                                <p class="py-3 text-sm text-muted-foreground">Belum ada activity.</p>
                            @endforelse
                        </div>
                    </section>

                    @if($completionIssues !== [])
                        <section class="lk-card border-warning/30 bg-warning-soft p-5" role="status">
                            <flux:heading size="lg">Belum siap selesai</flux:heading>
                            <ul class="mt-3 space-y-2 text-sm text-warning">@foreach($completionIssues as $issue)<li class="flex gap-2"><span aria-hidden="true">•</span><span>{{ $issue }}</span></li>@endforeach</ul>
                        </section>
                    @endif
                </aside>
            </div>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
