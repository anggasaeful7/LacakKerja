<?php
if (!function_exists('_25338f1a103c29f8dc0c62883ed8a5df')):
function _25338f1a103c29f8dc0c62883ed8a5df($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name' => null,
    'variant' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute it has been set manually
// but not if it has been set from the `wire:model` attribute...
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    // Adjust spacing between fields...
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/6fa86bcf5b3f9e49601a3759c8de5679.php'); ?>
<?php if (isset($__slots6fa86bcf5b3f9e49601a3759c8de5679)) { $__slotsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__slots6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php if (isset($__attrs6fa86bcf5b3f9e49601a3759c8de5679)) { $__attrsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__attrs6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php $__attrs6fa86bcf5b3f9e49601a3759c8de5679 = ['attributes' => $attributes]; ?>
<?php $__slots6fa86bcf5b3f9e49601a3759c8de5679 = []; ?>
<?php $__blaze->pushData($__attrs6fa86bcf5b3f9e49601a3759c8de5679); ?>
<?php ob_start(); ?>
    <ui-radio-group <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-radio-group>
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
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\radio\group\variants\default.blade.php ENDPATH**/ ?>