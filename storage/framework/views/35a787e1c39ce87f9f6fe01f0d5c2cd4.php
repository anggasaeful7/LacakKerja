<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'status' => 'synced',
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
    'status' => 'synced',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $labels = [
        'synced' => 'Tersinkronisasi',
        'syncing' => 'Menyinkronkan',
        'offline' => 'Offline · tersimpan lokal',
        'failed' => 'Sinkronisasi gagal',
    ];
    $colors = [
        'synced' => 'green',
        'syncing' => 'blue',
        'offline' => 'amber',
        'failed' => 'red',
    ];
    $icons = [
        'synced' => 'cloud',
        'syncing' => 'arrow-path',
        'offline' => 'signal-slash',
        'failed' => 'exclamation-triangle',
    ];
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/cffde9804881bb2b5f7284c583c5dca4.php'); ?>
<?php if (isset($__slotscffde9804881bb2b5f7284c583c5dca4)) { $__slotsStackcffde9804881bb2b5f7284c583c5dca4[] = $__slotscffde9804881bb2b5f7284c583c5dca4; } ?>
<?php if (isset($__attrscffde9804881bb2b5f7284c583c5dca4)) { $__attrsStackcffde9804881bb2b5f7284c583c5dca4[] = $__attrscffde9804881bb2b5f7284c583c5dca4; } ?>
<?php $__attrscffde9804881bb2b5f7284c583c5dca4 = ['color' => $colors[$status] ?? 'zinc','icon' => $icons[$status] ?? 'cloud','rounded' => true,'size' => 'sm','attributes' => $attributes]; ?>
<?php $__slotscffde9804881bb2b5f7284c583c5dca4 = []; ?>
<?php $__blaze->pushData($__attrscffde9804881bb2b5f7284c583c5dca4); ?>
<?php ob_start(); ?><?php echo e($labels[$status] ?? str($status)->headline()); ?><?php $__slotscffde9804881bb2b5f7284c583c5dca4['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscffde9804881bb2b5f7284c583c5dca4); ?>
<?php _cffde9804881bb2b5f7284c583c5dca4($__blaze, $__attrscffde9804881bb2b5f7284c583c5dca4, $__slotscffde9804881bb2b5f7284c583c5dca4, ['color', 'icon', 'rounded', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcffde9804881bb2b5f7284c583c5dca4)) { $__slotscffde9804881bb2b5f7284c583c5dca4 = array_pop($__slotsStackcffde9804881bb2b5f7284c583c5dca4); } ?>
<?php if (! empty($__attrsStackcffde9804881bb2b5f7284c583c5dca4)) { $__attrscffde9804881bb2b5f7284c583c5dca4 = array_pop($__attrsStackcffde9804881bb2b5f7284c583c5dca4); } ?>
<?php $__blaze->popData(); ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/components/lk-sync-badge.blade.php ENDPATH**/ ?>