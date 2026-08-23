<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __('Pengaturan organisasi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Pengaturan organisasi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-3xl space-y-8 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Pengaturan organisasi<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?>Kelola identitas workspace dan preferensi regional.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
                <?php ob_start(); ?><a href="<?php echo e(route('organization.members')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px]" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M8.5 4.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10.9 12.006c.11.542-.348.994-.9.994H2c-.553 0-1.01-.452-.902-.994a5.002 5.002 0 0 1 9.803 0ZM14.002 12h-1.59a2.556 2.556 0 0 0-.04-.29 6.476 6.476 0 0 0-1.167-2.603 3.002 3.002 0 0 1 3.633 1.911c.18.522-.283.982-.836.982ZM12 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Kelola anggota<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content"><?php echo e(session('status')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('organization.settings.update')); ?>" class="lk-card space-y-6 p-5 sm:p-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/38b67d1afb7a97540315963469340040.php'); ?>
<?php $__blaze->pushData(['name' => 'name','label' => __('Nama organisasi'),'value' => e(old('name', $organization->name)),'required' => true]); ?>
<?php _38b67d1afb7a97540315963469340040($__blaze, ['name' => 'name','label' => __('Nama organisasi'),'value' => e(old('name', $organization->name)),'required' => true], [], ['label', 'required'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/38b67d1afb7a97540315963469340040.php'); ?>
<?php $__blaze->pushData(['name' => 'slug','label' => __('Slug'),'value' => e(old('slug', $organization->slug)),'required' => true]); ?>
<?php _38b67d1afb7a97540315963469340040($__blaze, ['name' => 'slug','label' => __('Slug'),'value' => e(old('slug', $organization->slug)),'required' => true], [], ['label', 'required'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="timezone" class="mb-2 block text-sm font-medium text-foreground">Zona waktu</label>
                        <select id="timezone" name="timezone" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($timezone); ?>" <?php if(old('timezone', $organization->timezone) === $timezone): echo 'selected'; endif; ?>><?php echo e($timezone); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label for="currency" class="mb-2 block text-sm font-medium text-foreground">Mata uang</label>
                        <select id="currency" name="currency" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['IDR' => 'IDR · Rupiah', 'USD' => 'USD · Dollar', 'SGD' => 'SGD · Dollar Singapura']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($value); ?>" <?php if(old('currency', $organization->currency) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="flex justify-end">
                    <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>Simpan perubahan<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
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
<?php endif; ?>
<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/pages/organization/settings.blade.php ENDPATH**/ ?>