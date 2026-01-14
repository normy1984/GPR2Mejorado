<?php if (Auth::check() && Auth::user()->can('show.income.budget.plans_management|show.income.programmatic_structure.execution')): ?>
<div id="myModal" class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-dollar"></i> <?php echo e(trans('income.labels.detail'), false); ?>

        </h4>
    </div>

    <div class="mt-5">
        <form role="form" action="" method=""
              class="form-horizontal form-label-left" id="income_show_fm" novalidate>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_classifier_id">
                    <?php echo e(trans('income.labels.budgetClassifier'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="budget_classifier_id" name="budget_classifier_id" disabled>

                        <?php if($entity->budget_classifier): ?>
                            <option value=""><?php echo e($entity->budget_classifier->full_code, false); ?> - <?php echo e($entity->budget_classifier->title, false); ?></option>
                        <?php else: ?>
                            <option value=""></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="financing_source_id">
                    <?php echo e(trans('income.labels.financingSource'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="financing_source_id" name="financing_source_id" disabled>
                        <?php if($entity->financing_source): ?>
                            <option value=""><?php echo e($entity->financing_source->code, false); ?> - <?php echo e($entity->financing_source->description, false); ?></option>
                        <?php else: ?>
                            <option value=""></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="distributor_code">
                    <?php echo e(trans('income.labels.distributor'), false); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="distributor_code" disabled class="form-control"
                           placeholder="<?php echo e(trans('income.labels.code'), false); ?>" value="<?php echo e($entity->distributor_code, false); ?>"/>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" id="distributor_name" disabled class="form-control"
                           placeholder="<?php echo e(trans('income.labels.distributor_name'), false); ?>" value="<?php echo e($entity->distributor_name, false); ?>"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="institution_id">
                    <?php echo e(trans('income.labels.institution'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="institution_id" name="institution_id" disabled>
                        <?php if($entity->institution): ?>
                            <option value=""><?php echo e($entity->institution->code, false); ?> - <?php echo e($entity->institution->name, false); ?></option>
                        <?php else: ?>
                            <option value=""></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="loan_id">
                    <?php echo e(trans('income.labels.loan'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control" id="loan_id" name="loan_id" disabled>
                        <?php if($entity->loan): ?>
                            <option value=""><?php echo e($entity->loan->full_code, false); ?> - <?php echo e($entity->loan->title, false); ?></option>
                        <?php else: ?>
                            <option value=""></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="justification">
                    <?php echo e(trans('income.labels.justification'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                            <textarea type="text" name="justification" id="justification"
                                      class="form-control col-md-7 col-sm-7 col-xs-12" rows="4" maxlength="500" disabled><?php echo e($entity->justification, false); ?></textarea>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legal_base">
                    <?php echo e(trans('income.labels.legalBase'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                            <textarea type="text" name="legal_base" id="legal_base"
                                      class="form-control col-md-7 col-sm-7 col-xs-12" rows="4" maxlength="500" disabled><?php echo e($entity->legal_base, false); ?></textarea>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="value">
                    <?php echo e(trans('income.labels.value'), false); ?>

                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="input-group">
                         <span class="input-group-addon warning">
                                <span class="fa fa-dollar"></span>
                            </span>
                        <input type="text" name="value" id="value"
                               class="form-control col-md-7 col-sm-7 col-xs-12" value="<?php echo e($entity->value, false); ?>" disabled/>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo e(trans('app.labels.close'), false); ?></button>
            </div>

        </form>
    </div>
</div>

<script>
    $(() => {
        $('#value').number(true, 2)

        $('#institution_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectInstitution'), false); ?>',
            dropdownParent: $("#myModal")
        })

        $('#loan_id').select2({
            placeholder: '<?php echo e(trans('income.labels.selectLoan'), false); ?>',
            dropdownParent: $("#myModal")
        })

    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?><?php /**PATH /var/www/html/resources/views/business/planning/income/show.blade.php ENDPATH**/ ?>