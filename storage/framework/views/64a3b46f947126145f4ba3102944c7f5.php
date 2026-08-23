<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'value',
    'detail' => null,
    'icon' => 'chart-bar',
    'tone' => 'neutral',
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
    'label',
    'value',
    'detail' => null,
    'icon' => 'chart-bar',
    'tone' => 'neutral',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $toneClasses = [
        'neutral' => 'bg-surface-subtle text-secondary',
        'info' => 'bg-info-soft text-info',
        'success' => 'bg-success-soft text-success',
        'warning' => 'bg-warning-soft text-warning',
        'danger' => 'bg-danger-soft text-danger',
    ];
?>

<div <?php echo e($attributes->class('lk-card flex min-h-36 flex-col justify-between p-5')); ?>>
    <div class="flex items-start justify-between gap-4">
        <p class="text-sm font-medium text-on-surface-variant"><?php echo e($label); ?></p>
        <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-control <?php echo e($toneClasses[$tone] ?? $toneClasses['neutral']); ?>" aria-hidden="true">
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => $icon, 'class' => 'size-5']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/995fcf30025e3f51eec4ce3d730f2a62.php'); ?>
<?php $__blaze->pushData(['name' => $icon,'class' => 'size-5']); ?>
<?php _995fcf30025e3f51eec4ce3d730f2a62($__blaze, ['name' => $icon,'class' => 'size-5'], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        </span>
    </div>
    <div class="mt-5 flex items-end justify-between gap-3">
        <p class="lk-number text-3xl font-semibold tracking-tight text-on-surface"><?php echo e($value); ?></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail): ?>
            <p class="text-xs font-medium text-on-surface-variant"><?php echo e($detail); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\components\lk-stat-card.blade.php ENDPATH**/ ?>