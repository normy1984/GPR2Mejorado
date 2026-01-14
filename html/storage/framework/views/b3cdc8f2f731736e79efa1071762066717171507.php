

<?php $__env->startSection('form'); ?>
    <form id="login_fm" role="form" action="<?php echo e(route('login'), false); ?>" method="post" class="form-horizontal">

        <div class="col-md-4 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-3">
            <img src="<?php echo e(mix($logos['login_logo']), false); ?>" class="img-responsive"
                 style="width: 100%"/>
        </div>

        <?php echo csrf_field(); ?>

        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">

            <br>

            <?php if($timeout = session('session_time_out')): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?php echo e($timeout, false); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="item form-group" style="margin-bottom: 20px">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <input type="text" class="form-control" style="width: 85%; margin: auto; border-radius: 20px"
                           name="username" id="username"
                           value="<?php echo e(old('username'), false); ?>" placeholder="<?php echo trans('users.user.placeholders.username'); ?>">
                </div>

            </div>

            <div class="item form-group" style="margin-bottom: 20px">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="<?php echo trans('users.user.placeholders.password'); ?>"
                           style="width: 85%; margin: auto; border-radius: 20px">
                </div>
            </div>

            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <button class="btn btn-primary submit" style="margin-bottom: 20px; width: 85%; border-radius: 20px">
                    <?php echo e(trans('app.labels.login'), false); ?>

                </button>
                <?php if(Route::has('password.request')): ?>
                    <a class="btn btn-link" href="<?php echo e(route('password.request'), false); ?>">
                        <?php echo e(trans('auth.forgot_password'), false); ?>

                    </a>
                <?php endif; ?>
                <div class="clearfix"></div>

                <div class="separator" style="width: 85%; margin: auto;">
                    <div class="clearfix"></div>
                    <br/>
                    <p>
                        <strong>&copy; <?php echo (new \DateTime('now'))->format('Y'); ?> <?php echo e($labels['footer'], false); ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>

    <script>
        $(function () {

            $("#username").focus();

            var stack_center = {
                "dir1": "down",
                "dir2": "right",

            };

            <?php if($errors->has('username')): ?>
            new PNotify({
                title: 'Error accediendo al sistema',
                type: 'error',
                text: '<?php echo e($errors->first('username'), false); ?>',
                styling: 'bootstrap3',
                stack: stack_center,
                delay: 4000
            });

            <?php endif; ?>

            $('#login_fm').validate({
                ignore: [],
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    $('button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });

            $('html').css('background-color', '#eee');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>