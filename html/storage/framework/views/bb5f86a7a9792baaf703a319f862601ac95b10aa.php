

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.min.css'), false); ?>"
          rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.css.map'), false); ?>"
          rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css.map'), false); ?>"
          rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/css/custom.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('css/app.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('css/theme.css'), false); ?>" rel="stylesheet"/>

    <!-- Custom -->
    <link href="<?php echo e(mix('css/login.css'), false); ?>" rel="stylesheet"/>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('body_classes'); ?> login-page <?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <div>
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper" class="login_wrapper form d-flex justify-content-center align-items-center mt-0" style="max-width: none; background-color: #eee">
            <div id="login" style="background-color: white;">
                <section class="login_content">

                    <?php echo $__env->yieldContent('form'); ?>

                </section>
                <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-3 mt-3">
                        <img src="<?php echo e(mix('images/congope_1.png'), false); ?>" class="img-responsive"
                             style="width: 100%"/>
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <img src="<?php echo e(mix('images/logo_bid.png'), false); ?>" class="img-responsive"
                             style="width: 100%"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery/dist/jquery.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/jquery.validate.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/localization/messages_es.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.js'), false); ?>"></script>

    <?php echo $__env->yieldContent('page_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/layout.blade.php ENDPATH**/ ?>