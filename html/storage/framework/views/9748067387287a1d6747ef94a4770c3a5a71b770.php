<?php if (Auth::check() && Auth::user()->can('create.plans.plans_management')): ?>

<?php $Plan = app('\App\Models\Business\Plan'); ?>

<div>
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo e(trans('plans.title'), false); ?>

                <small><?php echo e(trans('app.labels.administration'), false); ?></small>
            </h3>
        </div>

        <div class="title_right hidden-xs">
            <ol class="breadcrumb pull-right">

                <?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>
                <li>
                    <a href="<?php echo e(route('index.plans.plans_management'), false); ?>" class="ajaxify"> <?php echo e(trans('plans.title'), false); ?></a>
                </li>
                <?php endif; ?>

                <li class="active"> <?php echo e(trans('app.labels.new'), false); ?></li>
            </ol>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <?php echo e(trans('plans.labels.new'), false); ?> <?php echo e(trans('plans.labels.' . $scope), false); ?>

                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>
                        <li class="pull-right">
                            <a href="<?php echo e(route('index.plans.plans_management'), false); ?>" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form role="form" action="<?php echo e(route('store.create.plans.plans_management'), false); ?>" method="post"
                          enctype="multipart/form-data"
                          class="form-horizontal form-label-left" id="businessPlansCreateFm" novalidate>

                        <?php echo csrf_field(); ?>

                        <input class="hidden" name="scope" id="scope" value="<?php echo e($scope, false); ?>">

                        <span class="section"><?php echo e(trans('plans.labels.info'), false); ?> <?php echo e(trans('plans.labels.' . $scope), false); ?></span>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">
                                <?php echo e(trans('plans.labels.is'), false); ?> <?php echo e($planName, false); ?>?
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="type_check" id="type_check" class="js-switch"/>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="type" name="type" type="hidden" value="<?php echo e($planName, false); ?>">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                <?php echo e(trans('plans.labels.name'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="name" id="name" maxlength="150"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.name'), false); ?>" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vision">
                                <?php echo e(trans('plans.labels.vision'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="vision" id="vision" class="form-control col-md-7 col-sm-7 col-xs-12"></textarea>
                            </div>
                        </div>

                        <?php if($scope == $Plan::SCOPE_INSTITUTIONAL): ?>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mission">
                                    <?php echo e(trans('plans.labels.mission'), false); ?>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="mission" id="mission" class="form-control col-md-7 col-sm-7 col-xs-12"></textarea>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startYear">
                                <?php echo e(trans('plans.labels.startYear'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="start_year" id="startYear" maxlength="4"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.startYear'), false); ?>" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="endYear">
                                <?php echo e(trans('plans.labels.endYear'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="end_year" id="endYear" maxlength="4"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.endYear'), false); ?>" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>
                            <a href="<?php echo e(route('index.plans.plans_management'), false); ?>" class="btn btn-info ajaxify">
                                <i class="fa fa-times"></i> <?php echo e(trans('app.labels.cancel'), false); ?>

                            </a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> <?php echo e(trans('plans.labels.save'), false); ?>

                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {

        let $form = $('#businessPlansCreateFm');

        $validateDefaults.rules = {
            name: {
                required: true,
                minlength: 2,
                remote: {
                    url: "<?php echo route('checkuniquefield'); ?>",
                    data: {
                        fieldName: 'name',
                        fieldValue: function () {
                            return $('#name', $form).val();
                        },
                        model: 'App\\Models\\Business\\Plan'
                    }
                }
            },
            type: {
                remote: {
                    url: "<?php echo route('checktype.create.plans.plans_management'); ?>",
                    data: {
                        type: () => {
                            return $("#type", $form).val();
                        },
                        type_check: () => {
                            return $("#type_check", $form).prop('checked');
                        }
                    }
                }
            },
            vision: {
                required: true
            },
            start_year: {
                required: true,
                digits: true,
                elt: '#endYear',
                // min: (new Date()).getFullYear(), //TODO this rule is disabled for now since we need to store old plans, maybe then it should be added
                minlength: 4,
                maxlength: 4,
                remote: {
                    url: "<?php echo route('check_start_year.create.plans.plans_management'); ?>",
                    data: {
                        fieldName: 'start_year',
                        year: () => {
                            return $('#startYear', $form).val();
                        },
                        type: () => {
                            return $('#type', $form).val();
                        },
                        type_check: () => {
                            return $('#type_check', $form).prop('checked');
                        }
                    }
                }
            },
            end_year: {
                required: true,
                digits: true,
                egt: '#startYear',
                minlength: 4,
                maxlength: 4
            }
        };

        $validateDefaults.messages = {
            name: {
                remote: '<?php echo e(trans('plans.messages.validations.uniqueName'), false); ?>'
            },
            type: {
                remote: '<?php echo e(trans('plans.messages.validations.checkType1'), false); ?> <?php echo e($planName, false); ?> <?php echo e(trans('plans.messages.validations.checkType2'), false); ?>'
            },
            start_year: {
                remote: '<?php echo e(trans('plans.messages.validations.checkStartYear'), false); ?>'
            }
        };

        $form.validate($validateDefaults);

        // Start: Validate start and end year
        $.validator.addMethod("elt", (value, element, param) => {
            return parseInt(value) <= parseInt($(param).val()) || !$(param).val()
        }, '<?php echo e(trans('plans.messages.validations.elt'), false); ?>');

        $.validator.addMethod("egt", (value, element, param) => {
            return parseInt(value) >= parseInt($(param).val()) || !$(param).val()
        }, '<?php echo e(trans('plans.messages.validations.egt'), false); ?>');

        $('#startYear').keyup(() => {
            $('#endYear').valid()
        });

        <?php if($scope == $Plan::SCOPE_INSTITUTIONAL): ?>
        $('#startYear').on('change', () => {
            if ($('#endYear').val() == '' && $('#startYear').valid()) {
                $('#endYear').val(parseInt($('#startYear').val()) + 5)
            }

            if ($('#startYear').valid()) {
                $('#endYear', $form).rules('add', {
                    max: parseInt($('#startYear').val()) + <?php echo e($Plan::PEI_DURATION, false); ?>

                })
            }
        });
        <?php endif; ?>

        $('#endYear').keyup(() => {
            $('#startYear').valid()
        });
        // End: Validate start and end year

        $('#type_check').change((e) => {
            if ($(e.currentTarget).prop('checked')) {
                <?php if($planAlreadyExists): ?>
                $('#startYear').val(<?php echo e($startYear, false); ?>)
                $('#startYear').attr('readonly', true);
                <?php endif; ?>
            } else {
                $('#startYear').val('')
                $('#startYear').attr('readonly', false);
            }
            $('#type').valid();
        })

        $form.ajaxForm($formAjaxDefaults);
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/plan/create.blade.php ENDPATH**/ ?>