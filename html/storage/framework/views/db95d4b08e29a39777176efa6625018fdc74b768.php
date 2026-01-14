<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'error' => false,
    'prefix' => null,
    'required' => false,
    'suffix' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'error' => false,
    'prefix' => null,
    'required' => false,
    'suffix' => null,
]); ?>
<?php foreach (array_filter(([
    'error' => false,
    'prefix' => null,
    'required' => false,
    'suffix' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<label
    <?php echo e($attributes->class(['filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse']), false); ?>

>
    <?php echo e($prefix, false); ?>


    <span
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'text-sm font-medium leading-4',
            'text-gray-700' => ! $error,
            'dark:text-gray-300' => (! $error) && config('forms.dark_mode'),
            'text-danger-700' => $error,
            'dark:text-danger-400' => $error && config('forms.dark_mode'),
        ]) ?>"
    >
        
        <?php echo e($slot, false); ?><?php if($required): ?><sup
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'text-danger-700 whitespace-nowrap font-medium',
                    'dark:text-danger-400' => config('forms.dark_mode'),
                ]) ?>"
            >
                *
            </sup>
        <?php endif; ?>
    </span>

    <?php echo e($suffix, false); ?>

</label>
<?php /**PATH /var/www/html/vendor/filament/forms/resources/views/components/field-wrapper/label.blade.php ENDPATH**/ ?>