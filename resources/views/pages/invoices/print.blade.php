<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $invoice->number }} · {{ $organization->name }}</title>
        <style>
            :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
            * { box-sizing: border-box; }
            body { margin: 0; background: #eef2f6; color: #0f172a; }
            .page { width: min(100%, 210mm); min-height: 297mm; margin: 24px auto; padding: 18mm; background: #fff; box-shadow: 0 12px 30px rgba(15, 23, 42, .12); }
            .toolbar { width: min(100%, 210mm); margin: 20px auto -8px; display: flex; justify-content: space-between; gap: 12px; }
            button, a { min-height: 44px; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 16px; background: #fff; color: #0f172a; font-weight: 600; text-decoration: none; cursor: pointer; }
            .primary { border-color: #0f766e; background: #0f766e; color: #fff; }
            .header, .meta, .totals, .footer { display: flex; justify-content: space-between; gap: 28px; }
            .header { align-items: flex-start; border-bottom: 2px solid #0f172a; padding-bottom: 24px; }
            h1, h2, p { margin: 0; }
            h1 { font-size: 28px; letter-spacing: -.03em; }
            h2 { font-size: 16px; }
            .muted { color: #64748b; }
            .small { font-size: 12px; line-height: 1.5; }
            .number { text-align: right; }
            .number strong { display: block; margin-top: 4px; font-size: 20px; }
            .meta { margin: 32px 0; }
            .meta > div { flex: 1; }
            .label { margin-bottom: 6px; color: #64748b; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
            table { width: 100%; border-collapse: collapse; font-size: 13px; }
            th { padding: 10px 0; border-bottom: 1px solid #cbd5e1; color: #64748b; font-size: 11px; letter-spacing: .06em; text-align: left; text-transform: uppercase; }
            td { padding: 14px 0; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
            th:not(:first-child), td:not(:first-child) { text-align: right; }
            .totals { justify-content: flex-end; margin-top: 24px; }
            .totals dl { width: 260px; margin: 0; }
            .totals div { display: flex; justify-content: space-between; gap: 16px; padding: 5px 0; font-size: 13px; }
            .totals .grand { margin-top: 8px; border-top: 2px solid #0f172a; padding-top: 12px; font-size: 16px; font-weight: 700; }
            .footer { margin-top: 64px; border-top: 1px solid #e2e8f0; padding-top: 18px; }
            @media (max-width: 640px) { .page { min-height: auto; margin: 0; padding: 24px; box-shadow: none; } .toolbar { margin: 12px; width: auto; } .header, .meta, .footer { flex-direction: column; } .number { text-align: left; } }
            @media print { body { background: #fff; } .toolbar { display: none; } .page { width: auto; min-height: auto; margin: 0; padding: 0; box-shadow: none; } @page { size: A4; margin: 18mm; } }
        </style>
    </head>
    <body>
        <div class="toolbar"><a href="{{ route('invoices.show', $invoice) }}">Kembali</a><button type="button" class="primary" onclick="window.print()">Cetak / Simpan PDF</button></div>
        <main class="page">
            <header class="header"><div><h1>{{ $organization->name }}</h1><p class="muted" style="margin-top: 8px">Invoice layanan lapangan</p></div><div class="number"><p class="label">Nomor invoice</p><strong>{{ $invoice->number }}</strong><p class="small muted" style="margin-top: 6px">{{ $invoice->status->label() }}</p></div></header>
            <section class="meta"><div><p class="label">Ditagihkan kepada</p><h2>{{ $invoice->customer->name }}</h2><p class="small muted" style="margin-top: 6px">{{ $invoice->customer->email ?: $invoice->customer->phone ?: 'Kontak pelanggan belum diisi' }}</p></div><div><p class="label">Tanggal invoice</p><p>{{ $invoice->issued_at?->format('d M Y') ?: 'Draft' }}</p><p class="small muted" style="margin-top: 8px">Jatuh tempo: {{ $invoice->due_date?->format('d M Y') ?: 'Tidak ditentukan' }}</p></div><div><p class="label">Referensi pekerjaan</p><p>{{ $invoice->workOrder?->number ?: 'Invoice manual' }}</p><p class="small muted" style="margin-top: 8px">Mata uang: {{ $invoice->currency }}</p></div></section>
            <table><thead><tr><th>Deskripsi</th><th>Qty</th><th>Harga satuan</th><th>Jumlah</th></tr></thead><tbody>@foreach($invoice->items as $item)<tr><td>{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>{{ $invoice->currency }} {{ number_format($item->unit_price, 0, ',', '.') }}</td><td>{{ $invoice->currency }} {{ number_format($item->line_total, 0, ',', '.') }}</td></tr>@endforeach</tbody></table>
            <section class="totals"><dl><div><dt>Subtotal</dt><dd>{{ number_format($invoice->subtotal, 0, ',', '.') }}</dd></div><div><dt>Diskon</dt><dd>− {{ number_format($invoice->discount_amount, 0, ',', '.') }}</dd></div><div><dt>Pajak ({{ $invoice->tax_rate }}%)</dt><dd>{{ number_format($invoice->tax_amount, 0, ',', '.') }}</dd></div><div class="grand"><dt>Total</dt><dd>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 0, ',', '.') }}</dd></div></dl></section>
            @if($invoice->notes)<section style="margin-top: 42px"><p class="label">Catatan</p><p class="small" style="white-space: pre-line">{{ $invoice->notes }}</p></section>@endif
            <footer class="footer"><p class="small muted">Terima kasih atas kepercayaan Anda.</p><p class="small muted">Dicetak {{ now()->format('d M Y H:i') }}</p></footer>
        </main>
    </body>
</html>
