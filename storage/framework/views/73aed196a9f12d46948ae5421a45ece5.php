<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'sidebar' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'sidebar' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sidebar): ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/brand.blade.php', $__blaze->compiledPath.'/e6e92dc4a5e58a14dae39db9e5551484.php'); ?>
<?php if (isset($__slotse6e92dc4a5e58a14dae39db9e5551484)) { $__slotsStacke6e92dc4a5e58a14dae39db9e5551484[] = $__slotse6e92dc4a5e58a14dae39db9e5551484; } ?>
<?php if (isset($__attrse6e92dc4a5e58a14dae39db9e5551484)) { $__attrsStacke6e92dc4a5e58a14dae39db9e5551484[] = $__attrse6e92dc4a5e58a14dae39db9e5551484; } ?>
<?php $__attrse6e92dc4a5e58a14dae39db9e5551484 = ['class' => 'text-white','name' => config('app.name', 'LacakKerja'),'attributes' => $attributes]; ?>
<?php $__slotse6e92dc4a5e58a14dae39db9e5551484 = []; ?>
<?php $__blaze->pushData($__attrse6e92dc4a5e58a14dae39db9e5551484); ?>
<?php ob_start(); ?>
         <?php ob_start(); ?>
            <?php if (isset($component)) { $__componentOriginal159d6670770cb479b1921cea6416c26c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal159d6670770cb479b1921cea6416c26c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo-icon','data' => ['class' => 'size-5 fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 fill-current text-white']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $attributes = $__attributesOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__attributesOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $component = $__componentOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__componentOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
        <?php $__slotse6e92dc4a5e58a14dae39db9e5551484['logo'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), ['class' => 'flex aspect-square size-8 items-center justify-center rounded-md bg-accent text-on-primary']); ?>
    <?php $__slotse6e92dc4a5e58a14dae39db9e5551484['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse6e92dc4a5e58a14dae39db9e5551484); ?>
<?php _e6e92dc4a5e58a14dae39db9e5551484($__blaze, $__attrse6e92dc4a5e58a14dae39db9e5551484, $__slotse6e92dc4a5e58a14dae39db9e5551484, ['name', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke6e92dc4a5e58a14dae39db9e5551484)) { $__slotse6e92dc4a5e58a14dae39db9e5551484 = array_pop($__slotsStacke6e92dc4a5e58a14dae39db9e5551484); } ?>
<?php if (! empty($__attrsStacke6e92dc4a5e58a14dae39db9e5551484)) { $__attrse6e92dc4a5e58a14dae39db9e5551484 = array_pop($__attrsStacke6e92dc4a5e58a14dae39db9e5551484); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/brand.blade.php', $__blaze->compiledPath.'/b7548233915e16e3f68d7322d770b99c.php'); ?>
<?php if (isset($__slotsb7548233915e16e3f68d7322d770b99c)) { $__slotsStackb7548233915e16e3f68d7322d770b99c[] = $__slotsb7548233915e16e3f68d7322d770b99c; } ?>
<?php if (isset($__attrsb7548233915e16e3f68d7322d770b99c)) { $__attrsStackb7548233915e16e3f68d7322d770b99c[] = $__attrsb7548233915e16e3f68d7322d770b99c; } ?>
<?php $__attrsb7548233915e16e3f68d7322d770b99c = ['name' => config('app.name', 'LacakKerja'),'attributes' => $attributes]; ?>
<?php $__slotsb7548233915e16e3f68d7322d770b99c = []; ?>
<?php $__blaze->pushData($__attrsb7548233915e16e3f68d7322d770b99c); ?>
<?php ob_start(); ?>
         <?php ob_start(); ?>
            <?php if (isset($component)) { $__componentOriginal159d6670770cb479b1921cea6416c26c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal159d6670770cb479b1921cea6416c26c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo-icon','data' => ['class' => 'size-5 fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 fill-current text-white']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $attributes = $__attributesOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__attributesOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $component = $__componentOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__componentOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
        <?php $__slotsb7548233915e16e3f68d7322d770b99c['logo'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), ['class' => 'flex aspect-square size-8 items-center justify-center rounded-md bg-accent text-on-primary']); ?>
    <?php $__slotsb7548233915e16e3f68d7322d770b99c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb7548233915e16e3f68d7322d770b99c); ?>
<?php _b7548233915e16e3f68d7322d770b99c($__blaze, $__attrsb7548233915e16e3f68d7322d770b99c, $__slotsb7548233915e16e3f68d7322d770b99c, ['name', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb7548233915e16e3f68d7322d770b99c)) { $__slotsb7548233915e16e3f68d7322d770b99c = array_pop($__slotsStackb7548233915e16e3f68d7322d770b99c); } ?>
<?php if (! empty($__attrsStackb7548233915e16e3f68d7322d770b99c)) { $__attrsb7548233915e16e3f68d7322d770b99c = array_pop($__attrsStackb7548233915e16e3f68d7322d770b99c); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\components\app-logo.blade.php ENDPATH**/ ?>