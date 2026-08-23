<x-layouts::app.technician :title="__('Sinkronisasi')">
    <div class="space-y-6" data-sync-center>
        <header>
            <p class="text-sm font-medium text-accent">{{ __('Perangkat teknisi') }}</p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-on-surface">Sinkronisasi</h1>
            <p class="mt-2 text-base text-on-surface-variant">Perubahan offline tetap tersimpan di perangkat sampai server mengonfirmasi.</p>
        </header>

        <section class="lk-panel border-s-accent p-5" aria-labelledby="sync-state-title">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 id="sync-state-title" class="font-semibold text-on-surface">Status perangkat</h2>
                    <p class="mt-1 text-sm text-on-surface-variant" data-sync-description>Memeriksa koneksi dan antrean lokal…</p>
                </div>
                <span class="inline-flex min-h-10 items-center rounded-full bg-surface-subtle px-3 text-xs font-semibold text-on-surface-variant" data-sync-state role="status" aria-live="polite">Memeriksa</span>
            </div>
            <dl class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="rounded-control border border-border bg-surface p-3"><dt class="text-xs text-muted-foreground">Menunggu</dt><dd class="mt-1 text-2xl font-semibold text-on-surface" data-sync-pending-count>0</dd></div>
                <div class="rounded-control border border-border bg-surface p-3"><dt class="text-xs text-muted-foreground">Konflik</dt><dd class="mt-1 text-2xl font-semibold text-warning-content" data-sync-conflict-count>0</dd></div>
                <div class="rounded-control border border-border bg-surface p-3"><dt class="text-xs text-muted-foreground">Gagal</dt><dd class="mt-1 text-2xl font-semibold text-danger-content" data-sync-failed-count>0</dd></div>
                <div class="rounded-control border border-border bg-surface p-3"><dt class="text-xs text-muted-foreground">Terakhir</dt><dd class="mt-1 text-sm font-semibold text-on-surface" data-sync-last-synced>Belum ada</dd></div>
            </dl>
            <div class="mt-5 flex flex-wrap gap-3">
                <button type="button" data-sync-now class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-60"><flux:icon.arrow-path class="size-5" />Sinkronkan sekarang</button>
                <button type="button" data-sync-refresh-cache class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control border border-border px-4 text-sm font-semibold text-on-surface transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40"><flux:icon.cloud-arrow-down class="size-5" />Perbarui data tersimpan</button>
            </div>
            <div class="mt-4 hidden rounded-control border border-info/30 bg-info-soft p-3 text-sm text-info-content" data-sync-update role="status" aria-live="polite">
                Versi aplikasi baru tersedia. <button type="button" data-sync-apply-update class="ms-1 font-semibold underline">Muat versi baru</button>
            </div>
        </section>

        <section class="lk-card overflow-hidden" aria-labelledby="sync-queue-title">
            <div class="border-b border-border px-5 py-4">
                <h2 id="sync-queue-title" class="font-semibold text-on-surface">Antrean perubahan</h2>
                <p class="mt-1 text-sm text-on-surface-variant">Konflik tidak diterapkan diam-diam. Tinjau sebelum mencoba ulang.</p>
            </div>
            <div data-sync-queue class="divide-y divide-border">
                <p class="p-6 text-center text-sm text-on-surface-variant">Memuat antrean lokal…</p>
            </div>
        </section>

        <section class="lk-card p-5" aria-labelledby="sync-safety-title">
            <h2 id="sync-safety-title" class="font-semibold text-on-surface">Yang tersedia saat offline</h2>
            <ul class="mt-3 space-y-2 text-sm text-on-surface-variant">
                <li class="flex gap-2"><flux:icon.check-circle class="mt-0.5 size-4 shrink-0 text-success" />Daftar tugas hari ini dan detail tugas yang pernah dibuka.</li>
                <li class="flex gap-2"><flux:icon.check-circle class="mt-0.5 size-4 shrink-0 text-success" />Checklist dan catatan disimpan lokal dengan ID operasi unik.</li>
                <li class="flex gap-2"><flux:icon.shield-check class="mt-0.5 size-4 shrink-0 text-success" />Data hanya disimpan untuk organisasi dan akun yang sedang aktif.</li>
            </ul>
        </section>

        <noscript><div class="lk-card border-warning/30 bg-warning-soft p-4 text-sm text-warning-content">JavaScript diperlukan untuk membaca antrean offline dan mengirimkannya kembali saat koneksi pulih.</div></noscript>
    </div>
</x-layouts::app.technician>