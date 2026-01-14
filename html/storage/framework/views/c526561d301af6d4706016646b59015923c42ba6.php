<?php if (Auth::check() && Auth::user()->can('edit.plans.plans_management')): ?>

<?php $Plan = app('\App\Models\Business\Plan'); ?>
<?php echo $__env->renderWhen($justifiable, 'business.planning.partials.justification.form_multiple', ['info' => trans('justifications.messages.default'), 'form' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

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

                <li class="active"> <?php echo e(trans('app.labels.edit'), false); ?></li>
            </ol>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <?php echo e(trans('plans.labels.edit'), false); ?> <?php echo e(trans('plans.labels.' . $scope), false); ?>

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

                <form role="form" action="<?php echo e(route('update.edit.plans.plans_management', ['id' => $entity->id]), false); ?>" method="post"
                      enctype="multipart/form-data"
                      class="form-horizontal form-label-left" id="businessPlansUpdateFm">

                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>

                    <?php echo $__env->renderWhen($justifiable, 'business.planning.partials.justification.form', ['action' => trans('justifications.actions.update'), 'info' => trans('justifications.messages.default'), 'type' => 'submit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

                    <div class="x_content">

                        <input class="hidden" name="scope" id="scope" value="<?php echo e($scope, false); ?>">

                        <span class="section"><?php echo e(trans('plans.labels.info'), false); ?> <?php echo e(trans('plans.labels.' . $scope), false); ?></span>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">
                                <?php echo e(trans('plans.labels.is'), false); ?> <?php echo e($planName, false); ?>?
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="type_check" id="type_check" class="js-switch" disabled <?php if(in_array($entity->type, $fixedPlans)): ?> checked <?php endif; ?>/>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                <?php echo e(trans('plans.labels.name'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="name" id="name" maxlength="150"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.name'), false); ?>"
                                       value="<?php echo e($entity->name, false); ?>"/>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vision">
                                <?php echo e(trans('plans.labels.vision'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="vision" id="vision" class="form-control col-md-7 col-sm-7 col-xs-12"><?php echo e($entity->vision, false); ?></textarea>
                            </div>
                        </div>

                        <?php if($scope == \App\Models\Business\Plan::SCOPE_INSTITUTIONAL): ?>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mission">
                                    <?php echo e(trans('plans.labels.mission'), false); ?>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="mission" id="mission" class="form-control col-md-7 col-sm-7 col-xs-12"><?php echo e($entity->mission, false); ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_year">
                                <?php echo e(trans('plans.labels.startYear'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="start_year" id="startYear" maxlength="4"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.startYear'), false); ?>"
                                       value="<?php echo e($entity->start_year, false); ?>"
                                       <?php if(in_array($entity->type, [$Plan::TYPE_PEI, $Plan::TYPE_PDOT]) || ($entity->status != $Plan::STATUS_DRAFT && $entity->type == $Plan::TYPE_SECTORAL)): ?>)
                                       disabled
                                       <?php endif; ?>
                                       autocomplete="off"
                                />
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_year">
                                <?php echo e(trans('plans.labels.endYear'), false); ?> <span class="required text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="end_year" id="endYear" maxlength="4"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"
                                       placeholder="<?php echo e(trans('plans.placeholders.endYear'), false); ?>"
                                       value="<?php echo e($entity->end_year, false); ?>"
                                       autocomplete="off"
                                       <?php if($draftPlan): ?>
                                           disabled
                                    <?php endif; ?>
                                />
                            </div>
                        </div>

                        <div class="text-center">
                            <?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>
                            <a href="<?php echo e(route('index.plans.plans_management'), false); ?>" class="btn btn-info ajaxify">
                                <i class="fa fa-times"></i> <?php echo e(trans('app.labels.cancel'), false); ?>

                            </a>
                            <?php endif; ?>

                            <?php echo $__env->renderWhen($justifiable, 'business.planning.partials.justification.button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

                            <?php if(!$justifiable): ?>
                                <button id="submitBtnPlan" class="btn btn-success">
                                    <i class="fa fa-check"></i> <?php echo e(trans('plans.labels.save'), false); ?>

                                </button>

                                <?php if(!count($entity->planElements) && in_array($entity->type, [$Plan::TYPE_PDOT, $Plan::TYPE_PEI])): ?>
                                    <a class="btn btn-warning ajaxify" href="<?php echo e(route('replicate.plans.plans_management', ['plan' => $entity->id, 'type' => $entity->type]), false); ?>">
                                        <i class="fa fa-copy"></i> <?php echo e(trans('plans.labels.replicate'), false); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="separator col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                        <div id="load-tree" class="col-lg-5 col-md-5 col-sm-5 col-xs-10 mt-3 pl-0"></div>

                        <div id="load-area" class="col-lg-7 col-md-7 col-sm-7 col-xs-10 mt-3 p-0"></div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(() => {

        const url = '<?php echo route('loadstructure.edit.plans.plans_management', ['id' => $entity->id]); ?>'

        pushRequest(url, '#load-tree', null, 'GET', {'_token': '<?php echo csrf_token(); ?>'});

        let $form = $('#businessPlansUpdateFm');

        $validateDefaults.rules = {
            name: {
                required: true,
                minlength: 2,
                notEqualTo: '<?php echo implode(',',$fixedPlans); ?>',
                remote: {
                    url: "<?php echo route('checkuniquefield'); ?>",
                    data: {
                        fieldName: 'name',
                        fieldValue: () => {
                            return $('#name', $form).val();
                        },
                        model: 'App\\Models\\Business\\Plan',
                        current: '<?php echo e($entity ->id, false); ?>'
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
                maxlength: 4
            },
            end_year: {
                required: true,
                digits: true,
                egt: '#startYear',
                minlength: 4,
                maxlength: 4
            },
            <?php if($justifiable): ?>

            // Add rules to validate justification modal fields
            justificationDescription: {
                required: true,
                maxlength: 500
            },
            justificationFile: {
                required: true,
                extension: 'pdf'
            },
            justificationDocumentReference: {
                required: true,
                maxlength: 50
            }

            <?php endif; ?>
        };

        $validateDefaults.messages = {
            name: {
                remote: '<?php echo e(trans('plans.messages.validations.uniqueName'), false); ?>'
            }
        };

        $form.validate($validateDefaults);

        // Validate plan name
        jQuery.validator.addMethod("notEqualTo", function (value, element, param) {
            const fixedPlans = param.split(',');
            let valid = true;

            fixedPlans.forEach((plan) => {
                if (value.toLowerCase() == plan.toLowerCase()) {
                    valid = false;
                }
            });

            return valid;

        }, '<?php echo e(trans('plans.messages.validations.reservedName'), false); ?>');

        <?php if(in_array($entity->type, $fixedPlans)): ?>
        $("#name", $form).rules("remove", "notEqualTo");
        <?php endif; ?>

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

        $('#endYear').keyup(() => {
            $('#startYear').valid()
        });
        // End: Validate start and end year

        $form.ajaxForm($formAjaxDefaults);

        <?php if($entity->type == $Plan::TYPE_PEI ): ?>
        if ($('#startYear').valid()) {
            $('#endYear', $form).rules('add', {
                max: parseInt($('#startYear').val()) + <?php echo e($Plan::PEI_DURATION, false); ?>

            })
        }
        <?php endif; ?>

        <?php if(in_array($entity->type, [$Plan::TYPE_PEI, $Plan::TYPE_PDOT, $Plan::TYPE_SECTORAL])): ?>

        <?php if($entity->status == $Plan::STATUS_DRAFT): ?>
        $('#startYear').on('change', () => {

            <?php if($entity->type == $Plan::TYPE_PEI ): ?>
            if ($('#endYear').val() == '' && $('#startYear').valid()) {
                $('#endYear').val(parseInt($('#startYear').val()) + <?php echo e($Plan::PEI_DURATION, false); ?>)
            }

            if ($('#startYear').valid()) {
                $('#endYear', $form).rules('add', {
                    max: parseInt($('#startYear').val()) + <?php echo e($Plan::PEI_DURATION, false); ?>

                })
            }
            <?php endif; ?>

        });
        <?php endif; ?>

        <?php endif; ?>

        <?php if($justifiable): ?>

        let permanotice = null

        $('#justificationBtn').click(() => {
            if ($('#startYear').val() != "<?php echo e($entity->start_year, false); ?>" || $('#endYear').val() != "<?php echo e($entity->end_year, false); ?>") {
                permanotice = notify('<?php echo e(trans('plans.messages.warning.changeDate'), false); ?>', 'warning', null, {
                        buttons: {
                            closer_hover: false,
                            sticker: false
                        },
                        hide: false
                    }
                )
            }
        })

        // Close modal before submit
        $form.submit((e) => {
            e.preventDefault()

            if (!$form.valid()) {
                return false;
            }

            if (permanotice && permanotice.remove) {
                permanotice.remove()
            }
            $('#justificationModal').modal('hide');
            return true;
        })

        // Custom justification modal dismiss
        $('#btnCancelJustification').removeAttr('data-dismiss')
        $('#btnCancelJustification').click(() => {
            if (permanotice && permanotice.remove) {
                permanotice.remove()
            }
            $('#justificationModal').modal('hide')
        })

        <?php else: ?>
        $('#submitBtnPlan').click((e) => {
            e.preventDefault()

            if ($form.valid()) {
                const url_submit = "<?php echo route('update.edit.plans.plans_management', ['id' => $entity->id]); ?>"
                let formData = new FormData($form[0]);

                if ($('#startYear').val() != "<?php echo e($entity->start_year, false); ?>" || $('#endYear').val() != "<?php echo e($entity->end_year, false); ?>") {
                    confirmModal('<?php echo e(trans('plans.messages.warning.changeDate'), false); ?>', () => {
                        pushRequest(url_submit, null, () => {

                        }, 'POST', formData, false, {form: true})
                    })
                } else {
                    pushRequest(url_submit, null, () => {

                    }, 'POST', formData, false, {form: true})
                }


            }
        })
        <?php endif; ?>
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/plan/update.blade.php ENDPATH**/ ?>