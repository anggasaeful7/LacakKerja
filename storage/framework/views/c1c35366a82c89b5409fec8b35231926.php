<?php
if (!function_exists('_c1c35366a82c89b5409fec8b35231926')):
function _c1c35366a82c89b5409fec8b35231926($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$classes = Flux::classes('[grid-area:footer]')
    ->add($attributes->has('container') ? '' : 'p-6 lg:p-8')
    ;
?>

<div <?php echo e($attributes->class($classes)); ?> data-flux-footer>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/b157619ccebe2bf4175316be1a183454.php'); ?>
<?php if (isset($__slotsb157619ccebe2bf4175316be1a183454)) { $__slotsStackb157619ccebe2bf4175316be1a183454[] = $__slotsb157619ccebe2bf4175316be1a183454; } ?>
<?php if (isset($__attrsb157619ccebe2bf4175316be1a183454)) { $__attrsStackb157619ccebe2bf4175316be1a183454[] = $__attrsb157619ccebe2bf4175316be1a183454; } ?>
<?php $__attrsb157619ccebe2bf4175316be1a183454 = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slotsb157619ccebe2bf4175316be1a183454 = []; ?>
<?php $__blaze->pushData($__attrsb157619ccebe2bf4175316be1a183454); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsb157619ccebe2bf4175316be1a183454['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb157619ccebe2bf4175316be1a183454); ?>
<?php _b157619ccebe2bf4175316be1a183454($__blaze, $__attrsb157619ccebe2bf4175316be1a183454, $__slotsb157619ccebe2bf4175316be1a183454, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb157619ccebe2bf4175316be1a183454)) { $__slotsb157619ccebe2bf4175316be1a183454 = array_pop($__slotsStackb157619ccebe2bf4175316be1a183454); } ?>
<?php if (! empty($__attrsStackb157619ccebe2bf4175316be1a183454)) { $__attrsb157619ccebe2bf4175316be1a183454 = array_pop($__attrsStackb157619ccebe2bf4175316be1a183454); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\footer.blade.php ENDPATH**/ ?>