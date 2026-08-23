<?php # [BlazeFolded]:{flux::icon.arrow-path}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/arrow-path.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.cloud-arrow-down}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/cloud-arrow-down.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.check-circle}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/check-circle.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.check-circle}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/check-circle.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.shield-check}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/shield-check.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.technician','data' => ['title' => __('Sinkronisasi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.technician'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Sinkronisasi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="space-y-6" data-sync-center>
        <header>
            <p class="text-sm font-medium text-accent"><?php echo e(__('Perangkat teknisi')); ?></p>
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
                <button type="button" data-sync-now class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-60"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Sinkronkan sekarang</button>
                <button type="button" data-sync-refresh-cache class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control border border-border px-4 text-sm font-semibold text-on-surface transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Perbarui data tersimpan</button>
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
                <li class="flex gap-2"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mt-0.5 size-4 shrink-0 text-success" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Daftar tugas hari ini dan detail tugas yang pernah dibuka.</li>
                <li class="flex gap-2"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mt-0.5 size-4 shrink-0 text-success" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Checklist dan catatan disimpan lokal dengan ID operasi unik.</li>
                <li class="flex gap-2"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mt-0.5 size-4 shrink-0 text-success" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Data hanya disimpan untuk organisasi dan akun yang sedang aktif.</li>
            </ul>
        </section>

        <noscript><div class="lk-card border-warning/30 bg-warning-soft p-4 text-sm text-warning-content">JavaScript diperlukan untuk membaca antrean offline dan mengirimkannya kembali saat koneksi pulih.</div></noscript>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf)): ?>
<?php $attributes = $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf; ?>
<?php unset($__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf)): ?>
<?php $component = $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf; ?>
<?php unset($__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf); ?>
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\technician\sync.blade.php ENDPATH**/ ?>