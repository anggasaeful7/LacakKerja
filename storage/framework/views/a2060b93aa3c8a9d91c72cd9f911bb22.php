<?php
if (!function_exists('_a2060b93aa3c8a9d91c72cd9f911bb22')):
function _a2060b93aa3c8a9d91c72cd9f911bb22($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

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
    'align' => 'right',
    'checked' => null
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$checked ??= $attributes['checked'] ?? $__defaults['checked']; unset($attributes['checked']);
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
    ->add('group h-5 w-8 min-w-8 relative inline-flex items-center outline-offset-2')
    ->add('rounded-full')
    ->add('transition')
    ->add('bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10')
    ->add('[print-color-adjust:exact]')
    ->add([
        'data-checked:bg-(--color-accent)',
        'data-checked:border-0',
    ])
    ;

$indicatorClasses = Flux::classes()
    ->add('size-3.5')
    ->add('rounded-full')
    ->add('transition translate-x-[0.1875rem] dark:translate-x-[0.125rem] rtl:-translate-x-[0.1875rem] dark:rtl:-translate-x-[0.125rem]')
    ->add('bg-white')
    ->add([
        'group-data-checked:translate-x-[0.9375rem] rtl:group-data-checked:-translate-x-[0.9375rem]',
        // We have to add the dark variant of the `translate-x-[0.9375rem]` to ensure that if `.dark` is added to an element mid way
        // down the DOM instead of on the root HTML element, that the above `dark:translate-x-[0.125rem]` doesn't over ride it...
        'dark:group-data-checked:translate-x-[0.9375rem] dark:rtl:group-data-checked:-translate-x-[0.9375rem]',
        'group-data-checked:bg-(--color-accent-foreground)',
    ]);
?>

<?php if ($align === 'left' || $align === 'start'): ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/babc85716f409312f56b69e571133247.php'); ?>
<?php if (isset($__slotsbabc85716f409312f56b69e571133247)) { $__slotsStackbabc85716f409312f56b69e571133247[] = $__slotsbabc85716f409312f56b69e571133247; } ?>
<?php if (isset($__attrsbabc85716f409312f56b69e571133247)) { $__attrsStackbabc85716f409312f56b69e571133247[] = $__attrsbabc85716f409312f56b69e571133247; } ?>
<?php $__attrsbabc85716f409312f56b69e571133247 = ['attributes' => $attributes]; ?>
<?php $__slotsbabc85716f409312f56b69e571133247 = []; ?>
<?php $__blaze->pushData($__attrsbabc85716f409312f56b69e571133247); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slotsbabc85716f409312f56b69e571133247['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsbabc85716f409312f56b69e571133247); ?>
<?php _babc85716f409312f56b69e571133247($__blaze, $__attrsbabc85716f409312f56b69e571133247, $__slotsbabc85716f409312f56b69e571133247, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackbabc85716f409312f56b69e571133247)) { $__slotsbabc85716f409312f56b69e571133247 = array_pop($__slotsStackbabc85716f409312f56b69e571133247); } ?>
<?php if (! empty($__attrsStackbabc85716f409312f56b69e571133247)) { $__attrsbabc85716f409312f56b69e571133247 = array_pop($__attrsStackbabc85716f409312f56b69e571133247); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php', $__blaze->compiledPath.'/146b6457e76e5619edbc7c9f778c31c9.php'); ?>
<?php if (isset($__slots146b6457e76e5619edbc7c9f778c31c9)) { $__slotsStack146b6457e76e5619edbc7c9f778c31c9[] = $__slots146b6457e76e5619edbc7c9f778c31c9; } ?>
<?php if (isset($__attrs146b6457e76e5619edbc7c9f778c31c9)) { $__attrsStack146b6457e76e5619edbc7c9f778c31c9[] = $__attrs146b6457e76e5619edbc7c9f778c31c9; } ?>
<?php $__attrs146b6457e76e5619edbc7c9f778c31c9 = ['attributes' => $attributes]; ?>
<?php $__slots146b6457e76e5619edbc7c9f778c31c9 = []; ?>
<?php $__blaze->pushData($__attrs146b6457e76e5619edbc7c9f778c31c9); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots146b6457e76e5619edbc7c9f778c31c9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots146b6457e76e5619edbc7c9f778c31c9); ?>
<?php _146b6457e76e5619edbc7c9f778c31c9($__blaze, $__attrs146b6457e76e5619edbc7c9f778c31c9, $__slots146b6457e76e5619edbc7c9f778c31c9, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack146b6457e76e5619edbc7c9f778c31c9)) { $__slots146b6457e76e5619edbc7c9f778c31c9 = array_pop($__slotsStack146b6457e76e5619edbc7c9f778c31c9); } ?>
<?php if (! empty($__attrsStack146b6457e76e5619edbc7c9f778c31c9)) { $__attrs146b6457e76e5619edbc7c9f778c31c9 = array_pop($__attrsStack146b6457e76e5619edbc7c9f778c31c9); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\switch.blade.php ENDPATH**/ ?>