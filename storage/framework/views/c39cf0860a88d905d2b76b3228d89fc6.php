<?php
if (!function_exists('_c39cf0860a88d905d2b76b3228d89fc6')):
function _c39cf0860a88d905d2b76b3228d89fc6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'interactive' => null,
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
    'toggleable' => null,
];
$interactive ??= $attributes['interactive'] ?? $__defaults['interactive']; unset($attributes['interactive']);
$position ??= $attributes['position'] ?? $__defaults['position']; unset($attributes['position']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$content ??= $attributes['content'] ?? $__defaults['content']; unset($attributes['content']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
$toggleable ??= $attributes['toggleable'] ?? $__defaults['toggleable']; unset($attributes['toggleable']);
unset($__defaults);
?>

<?php
// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
?>

<?php if ($toggleable): ?>
    <ui-dropdown position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/ddad38b1b9a000816baf1c23043b060b.php'); ?>
<?php if (isset($__slotsddad38b1b9a000816baf1c23043b060b)) { $__slotsStackddad38b1b9a000816baf1c23043b060b[] = $__slotsddad38b1b9a000816baf1c23043b060b; } ?>
<?php if (isset($__attrsddad38b1b9a000816baf1c23043b060b)) { $__attrsStackddad38b1b9a000816baf1c23043b060b[] = $__attrsddad38b1b9a000816baf1c23043b060b; } ?>
<?php $__attrsddad38b1b9a000816baf1c23043b060b = ['kbd' => $kbd]; ?>
<?php $__slotsddad38b1b9a000816baf1c23043b060b = []; ?>
<?php $__blaze->pushData($__attrsddad38b1b9a000816baf1c23043b060b); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsddad38b1b9a000816baf1c23043b060b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsddad38b1b9a000816baf1c23043b060b); ?>
<?php _ddad38b1b9a000816baf1c23043b060b($__blaze, $__attrsddad38b1b9a000816baf1c23043b060b, $__slotsddad38b1b9a000816baf1c23043b060b, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackddad38b1b9a000816baf1c23043b060b)) { $__slotsddad38b1b9a000816baf1c23043b060b = array_pop($__slotsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php if (! empty($__attrsStackddad38b1b9a000816baf1c23043b060b)) { $__attrsddad38b1b9a000816baf1c23043b060b = array_pop($__attrsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/ddad38b1b9a000816baf1c23043b060b.php'); ?>
<?php if (isset($__slotsddad38b1b9a000816baf1c23043b060b)) { $__slotsStackddad38b1b9a000816baf1c23043b060b[] = $__slotsddad38b1b9a000816baf1c23043b060b; } ?>
<?php if (isset($__attrsddad38b1b9a000816baf1c23043b060b)) { $__attrsStackddad38b1b9a000816baf1c23043b060b[] = $__attrsddad38b1b9a000816baf1c23043b060b; } ?>
<?php $__attrsddad38b1b9a000816baf1c23043b060b = ['kbd' => $kbd]; ?>
<?php $__slotsddad38b1b9a000816baf1c23043b060b = []; ?>
<?php $__blaze->pushData($__attrsddad38b1b9a000816baf1c23043b060b); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsddad38b1b9a000816baf1c23043b060b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsddad38b1b9a000816baf1c23043b060b); ?>
<?php _ddad38b1b9a000816baf1c23043b060b($__blaze, $__attrsddad38b1b9a000816baf1c23043b060b, $__slotsddad38b1b9a000816baf1c23043b060b, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackddad38b1b9a000816baf1c23043b060b)) { $__slotsddad38b1b9a000816baf1c23043b060b = array_pop($__slotsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php if (! empty($__attrsStackddad38b1b9a000816baf1c23043b060b)) { $__attrsddad38b1b9a000816baf1c23043b060b = array_pop($__attrsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\tooltip\index.blade.php ENDPATH**/ ?>