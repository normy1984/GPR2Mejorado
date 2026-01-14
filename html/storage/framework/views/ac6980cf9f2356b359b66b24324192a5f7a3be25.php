<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => null,
]); ?>
<?php foreach (array_filter(([
    'title' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!DOCTYPE html>
<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale()), false); ?>"
    dir="<?php echo e(__('filament::layout.direction') ?? 'ltr', false); ?>"
    class="filament js-focus-visible min-h-screen antialiased"
>
    <head>
        <?php echo e(\Filament\Facades\Filament::renderHook('head.start'), false); ?>


        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>" />

        <?php $__currentLoopData = \Filament\Facades\Filament::getMeta(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($tag, false); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($favicon = config('filament.favicon')): ?>
            <link rel="icon" href="<?php echo e($favicon, false); ?>" />
        <?php endif; ?>

        <title>
            <?php echo e($title ? "{$title} - " : null, false); ?> <?php echo e(config('filament.brand'), false); ?>

        </title>

        <?php echo e(\Filament\Facades\Filament::renderHook('styles.start'), false); ?>


        <style>
            [x-cloak=''],
            [x-cloak='x-cloak'],
            [x-cloak='1'] {
                display: none !important;
            }

            @media (max-width: 1023px) {
                [x-cloak='-lg'] {
                    display: none !important;
                }
            }

            @media (min-width: 1024px) {
                [x-cloak='lg'] {
                    display: none !important;
                }
            }

            :root {
                --sidebar-width: <?php echo e(config('filament.layout.sidebar.width') ?? '20rem', false); ?>;
                --collapsed-sidebar-width: <?php echo e(config('filament.layout.sidebar.collapsed_width') ?? '5.4rem', false); ?>;
            }
        </style>

        <?php echo \Livewire\Livewire::styles(); ?>


        <?php if(filled($fontsUrl = config('filament.google_fonts'))): ?>
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link
                rel="preconnect"
                href="https://fonts.gstatic.com"
                crossorigin
            />
            <link href="<?php echo e($fontsUrl, false); ?>" rel="stylesheet" />
        <?php endif; ?>

        <?php $__currentLoopData = \Filament\Facades\Filament::getStyles(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(\Illuminate\Support\Str::of($path)->startsWith(['http://', 'https://'])): ?>
                <link rel="stylesheet" href="<?php echo e($path, false); ?>" />
            <?php elseif(\Illuminate\Support\Str::of($path)->startsWith('<')): ?>
                <?php echo $path; ?>

            <?php else: ?>
                <link
                    rel="stylesheet"
                    href="<?php echo e(route('filament.asset', [
                            'file' => "{$name}.css",
                        ]), false); ?>"
                />
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo e(\Filament\Facades\Filament::getThemeLink(), false); ?>


        <?php echo e(\Filament\Facades\Filament::renderHook('styles.end'), false); ?>


        <?php if(config('filament.dark_mode')): ?>
            <script>
                const theme = localStorage.getItem('theme')

                if (
                    theme === 'dark' ||
                    (!theme &&
                        window.matchMedia('(prefers-color-scheme: dark)')
                            .matches)
                ) {
                    document.documentElement.classList.add('dark')
                }
            </script>
        <?php endif; ?>

        <?php echo e(\Filament\Facades\Filament::renderHook('head.end'), false); ?>

    </head>

    <body
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'filament-body min-h-screen overflow-y-auto bg-gray-100 text-gray-900',
            'dark:bg-gray-900 dark:text-gray-100' => config('filament.dark_mode'),
        ]) ?>"
    >
        <?php echo e(\Filament\Facades\Filament::renderHook('body.start'), false); ?>


        <?php echo e($slot, false); ?>


        <?php echo e(\Filament\Facades\Filament::renderHook('scripts.start'), false); ?>


        <?php echo \Livewire\Livewire::scripts(); ?>


        <script>
            window.filamentData = <?php echo json_encode(\Filament\Facades\Filament::getScriptData(), 15, 512) ?>
        </script>

        <?php $__currentLoopData = \Filament\Facades\Filament::getBeforeCoreScripts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(\Illuminate\Support\Str::of($path)->startsWith(['http://', 'https://'])): ?>
                <script defer src="<?php echo e($path, false); ?>"></script>
            <?php elseif(\Illuminate\Support\Str::of($path)->startsWith('<')): ?>
                <?php echo $path; ?>

            <?php else: ?>
                <script
                    defer
                    src="<?php echo e(route('filament.asset', [
                            'file' => "{$name}.js",
                        ]), false); ?>"
                ></script>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo $__env->yieldPushContent('beforeCoreScripts'); ?>

        <script
            defer
            src="<?php echo e(route('filament.asset', [
                    'id' => Filament\get_asset_id('app.js'),
                    'file' => 'app.js',
                ]), false); ?>"
        ></script>

        <?php if(config('filament.broadcasting.echo')): ?>
            <script
                defer
                src="<?php echo e(route('filament.asset', [
                        'id' => Filament\get_asset_id('echo.js'),
                        'file' => 'echo.js',
                    ]), false); ?>"
            ></script>

            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    window.Echo = new window.EchoFactory(<?php echo \Illuminate\Support\Js::from(config('filament.broadcasting.echo'))->toHtml() ?>)

                    window.dispatchEvent(new CustomEvent('EchoLoaded'))
                })
            </script>
        <?php endif; ?>

        <?php $__currentLoopData = \Filament\Facades\Filament::getScripts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(\Illuminate\Support\Str::of($path)->startsWith(['http://', 'https://'])): ?>
                <script defer src="<?php echo e($path, false); ?>"></script>
            <?php elseif(\Illuminate\Support\Str::of($path)->startsWith('<')): ?>
                <?php echo $path; ?>

            <?php else: ?>
                <script
                    defer
                    src="<?php echo e(route('filament.asset', [
                            'file' => "{$name}.js",
                        ]), false); ?>"
                ></script>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo $__env->yieldPushContent('scripts'); ?>

        <?php echo e(\Filament\Facades\Filament::renderHook('scripts.end'), false); ?>


        <?php echo e(\Filament\Facades\Filament::renderHook('body.end'), false); ?>

    </body>
</html>
<?php /**PATH /var/www/html/vendor/filament/filament/resources/views/components/layouts/base.blade.php ENDPATH**/ ?>