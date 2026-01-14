<?php if (Auth::check() && Auth::user()->can('edit.income.budget.plans_management|edit.income.programmatic_structure.execution')): ?>
<?php $Income = app('\App\Models\Business\Planning\Income'); ?>

<div id="myModal" class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-dollar"></i> <?php echo e(trans('income.labels.edit'), false); ?>

        </h4>
    </div>

    <div class="mt-5">
        <form role="form" action="<?php echo $routes['update']; ?>" method="post"
              class="form-horizontal form-label-left" id="income_edit_fm" novalidate>

            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_classifier_id">
                    <?php echo e(trans('income.labels.budgetClassifier'), false); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="budget_classifier_id" name="budget_classifier_id">
                        <option value=""></option>
                        <?php $__currentLoopData = $budgetClassifiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgetClassifier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($budgetClassifier->id, false); ?>"
                                    <?php if($budgetClassifier->id == $entity->budget_classifier_id): ?> selected <?php endif; ?>>
                                <?php echo e($budgetClassifier->full_code, false); ?> - <?php echo e($budgetClassifier->title, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="financing_source_id">
                    <?php echo e(trans('income.labels.financingSource'), false); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="financing_source_id" name="financing_source_id">
                        <option value=""></option>
                        <?php $__currentLoopData = $financingSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $financingSource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($financingSource->id, false); ?>"
                                    <?php if($financingSource->id == $entity->financing_source_id): ?> selected <?php endif; ?>>
                                <?php echo e($financingSource->code, false); ?> - <?php echo e($financingSource->description, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="distributor_code">
                    <?php echo e(trans('income.labels.distributor'), false); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" name="distributor_code" id="distributor_code" maxlength="2" autocomplete="off" class="form-control"
                           placeholder="<?php echo e(trans('income.labels.code'), false); ?>" value="<?php echo e($entity->distributor_code, false); ?>"/>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" name="distributor_name" id="distributor_name" maxlength="200" autocomplete="off" class="form-control"
                           placeholder="<?php echo e(trans('income.labels.distributor_name'), false); ?>" value="<?php echo e($entity->distributor_name, false); ?>"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="institution_id">
                    <?php echo e(trans('income.labels.institution'), false); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="institution_id" name="institution_id">
                        <option value=""></option>
                        <?php $__currentLoopData = $institutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($institution->id, false); ?>" <?php if($institution->id == $entity->institution_id): ?> selected <?php endif; ?>><?php echo e($institution->code, false); ?>

                                - <?php echo e($institution->name, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="loan_id">
                    <?php echo e(trans('income.labels.loan'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="input-group">
                        <select class="form-control" id="loan_id" name="loan_id">
                            <option value=""></option>
                            <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($loan->id, false); ?>" <?php if($loan->id == $entity->loan_id): ?> selected <?php endif; ?>><?php echo e($loan->full_code, false); ?> - <?php echo e($loan->title, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="input-group-addon clear-selection"
                              data-toggle="tooltip"
                              data-placement="right"
                              data-original-title="<?php echo e(trans('app.labels.clear_selection'), false); ?>">
                        <span class="glyphicon glyphicon-erase"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="justification">
                    <?php echo e(trans('income.labels.justification'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea type="text" name="justification" id="justification" class="form-control col-md-7 col-sm-7 col-xs-12" rows="4"
                              maxlength="500"><?php echo e($entity->justification, false); ?></textarea>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legal_base">
                    <?php echo e(trans('income.labels.legalBase'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea type="text" name="legal_base" id="legal_base" class="form-control col-md-7 col-sm-7 col-xs-12" rows="4"
                              maxlength="500"><?php echo e($entity->legal_base, false); ?></textarea>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="value">
                    <?php echo e(trans('income.labels.value'), false); ?> <?php if($module === $Income::MODULE['BUDGET']): ?><span class="text-danger">*</span><?php endif; ?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <?php if($module === $Income::MODULE['BUDGET']): ?>
                        <div class="input-group">
                             <span class="input-group-addon warning">
                                <span class="fa fa-dollar"></span>
                            </span>
                            <input type="text" name="value" id="value" maxlength="16" autocomplete="off"
                                   class="form-control col-md-7 col-sm-7 col-xs-12" value="<?php echo e($entity->value, false); ?>"/>
                        </div>
                    <?php else: ?>
                        <label class="mt-3">$ 0 </label>
                        <i role="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('income.labels.incomeValueTooltip'), false); ?>"
                           class="fa fa-info-circle blue"></i>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo e(trans('app.labels.cancel'), false); ?></button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?php echo e(trans('app.labels.save'), false); ?></button>
            </div>

        </form>
    </div>
</div>

<script>
    $(() => {

        let $form = $('#income_edit_fm');

        $('#value').number(true, 2)
        $('#value').on('focusin', (e) => {
            $(e.currentTarget).attr('maxlength', 16)
        })

        $validateDefaults.rules = {
            budget_classifier_id: {
                required: true
            },
            financing_source_id: {
                required: true,
            },
            value: {
                required: true,
                min: 0,
                max: <?php echo e($Income::MAX_ALLOWED_VALUE, false); ?>

            },
            distributor_code: {
                required: true,
                minlength: 2,
                maxlength: 2
            },
            distributor_name: {
                required: true,
                maxlength: 200
            }
        };

        $validateDefaults.messages = {
            value: {
                max: '<?php echo e(trans('income.messages.validation.max_value'), false); ?>'
            }
        };

        let validator = $form.validate($.extend(false, $validateDefaults));

        $('#budget_classifier_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectBudgetClassifier'), false); ?>',
            dropdownParent: $("#myModal")
        });

        $('#financing_source_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectFinancingSource'), false); ?>',
            dropdownParent: $("#myModal")
        });

        $('#institution_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectInstitution'), false); ?>',
            dropdownParent: $("#myModal")
        });

        $('#loan_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectLoan'), false); ?>',
            dropdownParent: $("#myModal")
        });

        $('select').on('change', (e) => {
            validator.element(e.currentTarget);
        });

        // Initialize clear selection buttons
        $('.input-group').each((index, element) => {
            let criterionSelect = $(element).find('select');
            let criterionClearButton = $(element).find('span.input-group-addon');

            criterionClearButton.on('click', () => {
                criterionSelect.val(null).trigger('change')
            })
        });

        let datatable = $('#incomes_tb').DataTable();

        $form.ajaxForm($.extend(false, $formAjaxDefaults, {
            success: (response) => {
                processResponse(response, null, () => {
                    $validateDefaults.rules = {};
                    $validateDefaults.messages = {};
                    $modal.modal('hide');
                    datatable.draw();
                });
            }
        }));

    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?><?php /**PATH /var/www/html/resources/views/business/planning/income/update.blade.php ENDPATH**/ ?>