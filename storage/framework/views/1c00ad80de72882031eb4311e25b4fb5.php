<?php # [BlazeFolded]:{flux::icon.arrow-left}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/arrow-left.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __('Profil teknisi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Profil teknisi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-4xl space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4"><div><a href="<?php echo e(route('dispatch.index', $returnQuery)); ?>" class="inline-flex min-h-11 items-center gap-2 text-sm font-medium text-accent hover:underline" wire:navigate><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Kembali ke dispatch</a><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mt-4" data-flux-heading><?php ob_start(); ?>Profil <?php echo e($user->name); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?>Identitas, keahlian, warna lane, dan jam kerja teknisi.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?></div></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?><div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status"><?php echo e(session('status')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <form method="POST" action="<?php echo e(route('dispatch.technicians.update', $user)); ?>" class="space-y-6" onsubmit="if (! confirm('Simpan profil teknisi?')) { return false; } const button = this.querySelector('button[type=submit]'); button.disabled = true; button.textContent = 'Menyimpan...'; return true;">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $returnQuery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><input type="hidden" name="return_<?php echo e($key); ?>" value="<?php echo e($value); ?>"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <section class="lk-card space-y-4 p-5 sm:p-6"><div><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Data utama<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><p class="mt-1 text-sm text-muted-foreground">Dipakai dispatcher untuk identifikasi cepat.</p></div><div class="grid gap-4 sm:grid-cols-2"><div><label for="employee_code" class="mb-2 block text-sm font-medium text-foreground">Employee code</label><input id="employee_code" name="employee_code" value="<?php echo e(old('employee_code', $profile->employee_code)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="phone" class="mb-2 block text-sm font-medium text-foreground">Nomor telepon</label><input id="phone" name="phone" type="tel" inputmode="tel" value="<?php echo e(old('phone', $profile->phone)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="skills" class="mb-2 block text-sm font-medium text-foreground">Skills</label><input id="skills" name="skills" value="<?php echo e(old('skills', implode(', ', $profile->skills ?? []))); ?>" placeholder="HVAC, Electrical" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><p class="mt-1 text-xs text-muted-foreground">Pisahkan dengan koma.</p></div><div><label for="display_color" class="mb-2 block text-sm font-medium text-foreground">Display color</label><input id="display_color" name="display_color" type="color" value="<?php echo e(old('display_color', $profile->display_color)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-1"></div></div></section>
                <section class="lk-card space-y-4 p-5 sm:p-6"><div><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Availability<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><p class="mt-1 text-sm text-muted-foreground">Kosongkan salah satu hari bila teknisi tidak tersedia.</p></div><div class="divide-y divide-border"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['mon' => 'Senin', 'tue' => 'Selasa', 'wed' => 'Rabu', 'thu' => 'Kamis', 'fri' => 'Jumat', 'sat' => 'Sabtu', 'sun' => 'Minggu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><div class="grid gap-3 py-3 sm:grid-cols-[8rem_1fr_1fr] sm:items-center"><span class="text-sm font-medium text-foreground"><?php echo e($label); ?></span><div><label for="availability-<?php echo e($day); ?>-start" class="sr-only"><?php echo e($label); ?> mulai</label><input id="availability-<?php echo e($day); ?>-start" type="time" name="availability[<?php echo e($day); ?>][start]" value="<?php echo e(old('availability.'.$day.'.start', $profile->availabilityFor($day)['start'] ?? '')); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="availability-<?php echo e($day); ?>-end" class="sr-only"><?php echo e($label); ?> selesai</label><input id="availability-<?php echo e($day); ?>-end" type="time" name="availability[<?php echo e($day); ?>][end]" value="<?php echo e(old('availability.'.$day.'.end', $profile->availabilityFor($day)['end'] ?? '')); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div></div><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></div></section>
                <div class="flex flex-wrap justify-end gap-3"><?php ob_start(); ?><a href="<?php echo e(route('dispatch.index', $returnQuery)); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <?php ob_start(); ?>Batal<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Simpan profil<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?></div>
            </form>
        </div>
    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $attributes = $__attributesOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__attributesOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $component = $__componentOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__componentOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\dispatch\technician-profile.blade.php ENDPATH**/ ?>