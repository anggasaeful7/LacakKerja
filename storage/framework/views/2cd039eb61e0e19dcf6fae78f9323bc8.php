<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php
    $editing = $workOrder->exists;
    $selectedTechnician = old('technician_id', $workOrder->primaryAssignment?->user_id);
    $selectedCustomer = (int) old('customer_id', $workOrder->customer_id);
    $selectedSite = (int) old('customer_site_id', $workOrder->customer_site_id);
    $selectedAsset = (int) old('asset_id', $workOrder->asset_id);
    $selectedService = (int) old('service_id', $workOrder->service_id);
?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => $editing ? __('Ubah work order') : __('Buat work order')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? __('Ubah work order') : __('Buat work order'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-5xl space-y-6 p-4 sm:p-6 lg:p-8">
            <div>
                <?php ob_start(); ?><a href="<?php echo e($editing ? route('work-orders.show', $workOrder) : route('work-orders.index')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Kembali ke work order<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
                <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mt-3" data-flux-heading><?php ob_start(); ?><?php echo e($editing ? 'Ubah work order' : 'Buat work order'); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?><?php echo e($editing ? $workOrder->number.' · Perbarui detail pekerjaan yang belum terkunci.' : 'Isi detail inti pekerjaan. Jadwal dan teknisi dapat ditambahkan sekarang atau nanti.'); ?><?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <form method="POST" action="<?php echo e($editing ? route('work-orders.update', $workOrder) : route('work-orders.store')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editing): ?> <?php echo method_field('PUT'); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Identitas pekerjaan<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                        <p class="mt-1 text-sm text-muted-foreground">Hubungkan pekerjaan ke customer, site, aset, dan layanan.</p>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="title" class="mb-2 block text-sm font-medium text-foreground">Ringkasan masalah <span class="text-danger">*</span></label>
                            <input id="title" name="title" value="<?php echo e(old('title', $workOrder->title)); ?>" required placeholder="Contoh: AC lantai 12 tidak dingin" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="customer_id" class="mb-2 block text-sm font-medium text-foreground">Pelanggan <span class="text-danger">*</span></label>
                            <select id="customer_id" name="customer_id" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih pelanggan</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($customer->id); ?>" <?php if($selectedCustomer === $customer->id): echo 'selected'; endif; ?>><?php echo e($customer->name); ?> · <?php echo e($customer->customer_number); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="customer_site_id" class="mb-2 block text-sm font-medium text-foreground">Lokasi / site <span class="text-danger">*</span></label>
                            <select id="customer_site_id" name="customer_site_id" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih site</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $customer->sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($site->id); ?>" <?php if($selectedSite === $site->id): echo 'selected'; endif; ?>><?php echo e($customer->name); ?> · <?php echo e($site->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_site_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="asset_id" class="mb-2 block text-sm font-medium text-foreground">Aset</label>
                            <select id="asset_id" name="asset_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Tanpa aset spesifik</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($asset->id); ?>" <?php if($selectedAsset === $asset->id): echo 'selected'; endif; ?>><?php echo e($asset->asset_identifier); ?> · <?php echo e($asset->name); ?> · <?php echo e($asset->customer->name); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['asset_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="service_id" class="mb-2 block text-sm font-medium text-foreground">Layanan</label>
                            <select id="service_id" name="service_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Pilih bila memakai katalog layanan</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($service->id); ?>" <?php if($selectedService === $service->id): echo 'selected'; endif; ?>><?php echo e($service->name); ?> · <?php echo e(number_format((float) $service->base_price, 0, ',', '.')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="priority" class="mb-2 block text-sm font-medium text-foreground">Prioritas <span class="text-danger">*</span></label>
                            <select id="priority" name="priority" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\WorkOrderPriority::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($priority->value); ?>" <?php if(old('priority', $workOrder->priority?->value ?? 'normal') === $priority->value): echo 'selected'; endif; ?>><?php echo e($priority->label()); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="estimated_total" class="mb-2 block text-sm font-medium text-foreground">Estimasi biaya (IDR)</label>
                            <input id="estimated_total" name="estimated_total" type="number" min="0" step="1" value="<?php echo e(old('estimated_total', $workOrder->estimated_total ?? 0)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['estimated_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </section>

                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Jadwal dan penugasan<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                        <p class="mt-1 text-sm text-muted-foreground">Work order akan tetap draft jika jadwal atau teknisi belum lengkap.</p>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-3">
                        <div>
                            <label for="scheduled_start" class="mb-2 block text-sm font-medium text-foreground">Mulai terjadwal</label>
                            <input id="scheduled_start" name="scheduled_start" type="datetime-local" value="<?php echo e(old('scheduled_start', $workOrder->scheduled_start?->format('Y-m-d\TH:i'))); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['scheduled_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="scheduled_end" class="mb-2 block text-sm font-medium text-foreground">Selesai terjadwal</label>
                            <input id="scheduled_end" name="scheduled_end" type="datetime-local" value="<?php echo e(old('scheduled_end', $workOrder->scheduled_end?->format('Y-m-d\TH:i'))); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['scheduled_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="technician_id" class="mb-2 block text-sm font-medium text-foreground">Teknisi utama</label>
                            <select id="technician_id" name="technician_id" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                <option value="">Belum ditugaskan</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($membership->user_id); ?>" <?php if((int) $selectedTechnician === (int) $membership->user_id): echo 'selected'; endif; ?>><?php echo e($membership->user->name); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['technician_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label for="sla_due_at" class="mb-2 block text-sm font-medium text-foreground">Batas SLA</label>
                        <input id="sla_due_at" name="sla_due_at" type="datetime-local" value="<?php echo e(old('sla_due_at', $workOrder->sla_due_at?->format('Y-m-d\TH:i'))); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sla_due_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>

                <section class="lk-card space-y-5 p-5 sm:p-7">
                    <div>
                        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Deskripsi dan instruksi<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                        <p class="mt-1 text-sm text-muted-foreground">Tuliskan konteks yang perlu diketahui dispatcher dan teknisi.</p>
                    </div>
                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-foreground">Deskripsi pekerjaan</label>
                        <textarea id="description" name="description" rows="5" class="w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground"><?php echo e(old('description', $workOrder->description)); ?></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <?php ob_start(); ?><a href="<?php echo e($editing ? route('work-orders.show', $workOrder) : route('work-orders.index')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <?php ob_start(); ?>Batal<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?><?php echo e($editing ? 'Simpan perubahan' : 'Buat work order'); ?><?php echo trim(ob_get_clean()); ?></span>
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
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\work-orders\form.blade.php ENDPATH**/ ?>