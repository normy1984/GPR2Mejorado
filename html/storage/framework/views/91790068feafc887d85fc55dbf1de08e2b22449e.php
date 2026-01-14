

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css.map'), false); ?>"
          rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/css/custom.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('css/app.css'), false); ?>" rel="stylesheet"/>

    <!-- Custom -->
    <link href="<?php echo e(mix('css/modules_index.css'), false); ?>" rel="stylesheet"/>

    <!-- Spinner -->
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.css.map'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/nprogress/nprogress.css'), false); ?>" rel="stylesheet"/>

    <!-- Notifications -->
    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.nonblock.css'), false); ?>" rel="stylesheet"/>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <div id="wrapper" class="d-flex justify-content-center modules-main">
        <div class="row align-center modules-background">

            <div class="d-flex align-items-center justify-content-between">
                <span></span>
                <h3><?php echo e(trans('app.labels.modules'), false); ?></h3>
                <div class="text-right">
                    <form action="<?php echo e(route('logout'), false); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="modules-logout"><?php echo e(trans('app.labels.logout'), false); ?></button>
                    </form>
                </div>
            </div>

            <table class="table mt-3">
                <tr>
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="d-inline-grid ml-3 mr-3">
                            <a href="<?php echo e(route('index.app', ['module' => $module]), false); ?>">
                                <img src="<?php echo e(mix($module->image), false); ?>" class="clickable-image"/>
                            </a>
                            <h3 class="pt-3"><?php echo e($module->name, false); ?></h3>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </table>

            <div class="separator col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                <p><strong>&copy; <?php echo (new \DateTime('now'))->format('Y'); ?> <?php echo e($labels['footer'], false); ?></strong></p>
            </div>

            <!-- Util large modal -->
            <div id="util-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg <?php if(!session('changedPassword')): ?> no-passwd <?php endif; ?>">
                    <!-- Load modal content by AJAX -->
                </div>
            </div>

            <!-- Loading spinner -->
            <div id="loading-spinner">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="padding-top: 10px;">
                        <i class="fa fa-spinner fa-spin" style="font-size: 5em;"></i>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery/dist/jquery.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery/dist/jquery.min.map'), false); ?>" type="application/json"></script>
    <script src="<?php echo e(mix('vendor/jquery-form/jquery.form.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-form/jquery.form.min.js.map'), false); ?>" type="application/json"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/jquery.validate.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/nprogress/nprogress.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.nonblock.js'), false); ?>"></script>

    <script src="<?php echo e(mix('js/main.js'), false); ?>"></script>

    <script>
        $(() => {
            <?php if(session('changedPassword')): ?>
            hideLoading();
            <?php endif; ?>
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/layout/modules/index.blade.php ENDPATH**/ ?>