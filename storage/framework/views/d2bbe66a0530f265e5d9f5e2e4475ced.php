<?php
if (!function_exists('_d2bbe66a0530f265e5d9f5e2e4475ced')):
function _d2bbe66a0530f265e5d9f5e2e4475ced($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'variant' => null,
    'size' => null,
    'name' => null,
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute on the radio if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('flex flex-wrap gap-3')
    ;
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/6fa86bcf5b3f9e49601a3759c8de5679.php'); ?>
<?php if (isset($__slots6fa86bcf5b3f9e49601a3759c8de5679)) { $__slotsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__slots6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php if (isset($__attrs6fa86bcf5b3f9e49601a3759c8de5679)) { $__attrsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__attrs6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php $__attrs6fa86bcf5b3f9e49601a3759c8de5679 = ['attributes' => $attributes]; ?>
<?php $__slots6fa86bcf5b3f9e49601a3759c8de5679 = []; ?>
<?php $__blaze->pushData($__attrs6fa86bcf5b3f9e49601a3759c8de5679); ?>
<?php ob_start(); ?>
    <ui-radio-group <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-radio-group-pills>
        <?php echo e($slot); ?>

    </ui-radio-group>
<?php $__slots6fa86bcf5b3f9e49601a3759c8de5679['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6fa86bcf5b3f9e49601a3759c8de5679); ?>
<?php _6fa86bcf5b3f9e49601a3759c8de5679($__blaze, $__attrs6fa86bcf5b3f9e49601a3759c8de5679, $__slots6fa86bcf5b3f9e49601a3759c8de5679, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6fa86bcf5b3f9e49601a3759c8de5679)) { $__slots6fa86bcf5b3f9e49601a3759c8de5679 = array_pop($__slotsStack6fa86bcf5b3f9e49601a3759c8de5679); } ?>
<?php if (! empty($__attrsStack6fa86bcf5b3f9e49601a3759c8de5679)) { $__attrs6fa86bcf5b3f9e49601a3759c8de5679 = array_pop($__attrsStack6fa86bcf5b3f9e49601a3759c8de5679); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\radio\group\variants\pills.blade.php ENDPATH**/ ?>