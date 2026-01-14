<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e($labels['system_name'], false); ?> | <?php echo e($labels['system_slogan'], false); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(mix($logos['menu_logo']), false); ?>"/>

    <!-- Styles -->
<?php echo $__env->yieldContent('styles'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo e(mix('vendor/html5shiv/html5shiv.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/html5shiv/html5shiv-printshiv.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/respond/respond.min.js'), false); ?>"></script>

    <![endif]-->
</head>

<body class="<?php echo $__env->yieldPushContent('body_classes'); ?>">

<?php echo $__env->yieldContent('body'); ?>

<!-- Scripts -->
<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/layout/base.blade.php ENDPATH**/ ?>