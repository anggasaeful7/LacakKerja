<x-layouts::app.sidebar :title="__('Invoice')">
    <flux:main>
        <div class="mx-auto w-full max-w-[1440px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <flux:heading size="xl">Invoice</flux:heading>
                    <flux:subheading class="mt-1">Tagihkan pekerjaan selesai dan pantau pembayaran tanpa kehilangan jejak transaksi.</flux:subheading>
                </div>
                <flux:button href="{{ route('invoices.create') }}" variant="primary" icon="plus" wire:navigate>Buat invoice</flux:button>
            </div>

            @if(session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status">{{ session('status') }}</div>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan keuangan">
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Outstanding</p><p class="mt-2 text-2xl font-semibold tabular-nums text-foreground">{{ $organization->currency }} {{ number_format($kpis['outstanding'], 0, ',', '.') }}</p><p class="mt-1 text-sm text-muted-foreground">Total amount due aktif</p></div>
                <div class="lk-card border-danger/25 p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Jatuh tempo</p><p class="mt-2 text-2xl font-semibold tabular-nums text-danger-content">{{ number_format($kpis['overdue'], 0, ',', '.') }}</p><p class="mt-1 text-sm text-muted-foreground">Invoice perlu ditindaklanjuti</p></div>
                <div class="lk-card border-success/25 p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Dibayar bulan ini</p><p class="mt-2 text-2xl font-semibold tabular-nums text-success-content">{{ $organization->currency }} {{ number_format($kpis['paid_this_month'], 0, ',', '.') }}</p><p class="mt-1 text-sm text-muted-foreground">Pembayaran terposting</p></div>
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Draft</p><p class="mt-2 text-2xl font-semibold tabular-nums text-foreground">{{ number_format($kpis['drafts'], 0, ',', '.') }}</p><p class="mt-1 text-sm text-muted-foreground">Belum diterbitkan</p></div>
            </section>

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-[minmax(0,1fr)_13rem_auto] sm:items-end">
                <div class="min-w-0">
                    <label for="invoice-search" class="mb-2 block text-sm font-medium text-foreground">Cari invoice</label>
                    <input id="invoice-search" name="q" value="{{ $search }}" placeholder="Nomor, pelanggan, work order" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div class="min-w-0">
                    <label for="invoice-status" class="mb-2 block text-sm font-medium text-foreground">Status</label>
                    <select id="invoice-status" name="status" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua status</option>
                        @foreach(\App\Enums\InvoiceStatus::cases() as $invoiceStatus)
                            <option value="{{ $invoiceStatus->value }}" @selected($status === $invoiceStatus)>{{ $invoiceStatus->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <flux:button type="submit" variant="outline" icon="funnel">Terapkan</flux:button>
            </form>

            <section class="lk-card overflow-hidden" aria-labelledby="invoice-list-title">
                <div class="border-b border-border px-5 py-4 sm:px-6">
                    <flux:heading size="lg" id="invoice-list-title">Daftar invoice</flux:heading>
                    <p class="mt-1 text-sm text-muted-foreground">{{ $invoices->total() }} invoice dalam workspace ini.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[980px] w-full divide-y divide-border text-sm">
                        <caption class="sr-only">Daftar invoice dan status pembayarannya</caption>
                        <thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th scope="col" class="px-5 py-3 font-medium">Invoice</th><th scope="col" class="px-5 py-3 font-medium">Pelanggan</th><th scope="col" class="px-5 py-3 font-medium">Terbit / jatuh tempo</th><th scope="col" class="px-5 py-3 text-right font-medium">Total</th><th scope="col" class="px-5 py-3 font-medium">Status</th><th scope="col" class="px-5 py-3 text-right font-medium">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-border">
                            @forelse($invoices as $invoice)
                                @php
                                    $statusColors = ['draft' => 'zinc', 'issued' => 'blue', 'partially_paid' => 'amber', 'paid' => 'green', 'overdue' => 'red', 'void' => 'zinc'];
                                @endphp
                                <tr class="transition hover:bg-surface-subtle/70">
                                    <td class="px-5 py-4"><a href="{{ route('invoices.show', $invoice) }}" class="font-semibold text-accent hover:underline" wire:navigate>{{ $invoice->number }}</a><p class="mt-1 text-xs text-muted-foreground">{{ $invoice->workOrder?->number ?: 'Invoice manual' }}</p></td>
                                    <td class="px-5 py-4"><p class="font-medium text-foreground">{{ $invoice->customer->name }}</p><p class="mt-1 text-xs text-muted-foreground">{{ $invoice->customer->customer_number }}</p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-muted-foreground"><p>{{ $invoice->issued_at?->format('d M Y') ?: 'Belum terbit' }}</p><p class="mt-1 text-xs">Jatuh tempo: {{ $invoice->due_date?->format('d M Y') ?: '—' }}</p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right font-semibold tabular-nums text-foreground">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 0, ',', '.') }}<p class="mt-1 text-xs font-normal text-muted-foreground">Sisa {{ number_format($invoice->amount_due, 0, ',', '.') }}</p></td>
                                    <td class="whitespace-nowrap px-5 py-4"><flux:badge :color="$statusColors[$invoice->status->value] ?? 'zinc'" :icon="$invoice->status === \App\Enums\InvoiceStatus::Paid ? 'check-circle' : ($invoice->status === \App\Enums\InvoiceStatus::Overdue ? 'exclamation-triangle' : 'document-text')" size="sm">{{ $invoice->status->label() }}</flux:badge></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right"><flux:button href="{{ route('invoices.show', $invoice) }}" variant="ghost" size="sm" icon="arrow-right" wire:navigate>Lihat</flux:button></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-5"><x-lk-empty-state icon="banknotes" title="Belum ada invoice" description="Buat invoice dari work order yang sudah selesai untuk mulai mencatat penagihan."><flux:button href="{{ route('invoices.create') }}" variant="primary" icon="plus" wire:navigate>Buat invoice</flux:button></x-lk-empty-state></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($invoices->hasPages())<div class="border-t border-border px-5 py-4 sm:px-6">{{ $invoices->links() }}</div>@endif
            </section>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
