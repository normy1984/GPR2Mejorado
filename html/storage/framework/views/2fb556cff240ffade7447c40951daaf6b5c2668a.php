<?php use Carbon\Carbon; ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-key"></i> <?php echo e(trans('app.labels.change_fiscal_year_modal'), false); ?></h4>
    </div>

    <form id="change_fiscal_year_fm" class="form-horizontal" role="form" method="POST"
          action="<?php echo e(route('update.change_fiscal_year.users'), false); ?>" autocomplete="off" novalidate>

        <?php echo csrf_field(); ?>
        <input type="hidden" name="year" value="on">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="planning">
                            <?php echo e(trans('app.labels.fiscal_year_planning'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select name="planning" id="planning" class="form-control">
                                <option value=""></option>
                                <?php $__currentLoopData = $fiscalYearPlan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($year->year, false); ?>"
                                            <?php if(($fiscalYearPlanning == $year->year)): ?> selected <?php endif; ?>>
                                        <?php echo e($year->year, false); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="execution">
                            <?php echo e(trans('app.labels.fiscal_year_execution'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select name="execution" id="execution" class="form-control">
                                <option value=""></option>





                                <?php $__currentLoopData = $fiscalYearExec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($year->year, false); ?>" <?php if(($fiscalYearExecution== $year->year)): ?> selected <?php endif; ?>>
                                        <?php echo e($year->year, false); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-info ajaxify" data-dismiss="modal"> <?php echo e(trans('app.labels.cancel'), false); ?></button>
            <button type="submit" class="btn btn-success"> <?php echo e(trans('app.labels.accept'), false); ?></button>
        </div>
    </form>
</div>

<script>
    $(function () {
        var $form = $('#change_fiscal_year_fm');

        $validateDefaults.rules = {
            planning: {
                required: true
            },
            execution: {
                required: true
            }
        };

        $.validator.prototype.ruleValidationStatus = function (element) {
            element = $(element)[0];
            let rules = $(element).rules();
            let errors = {};
            for (let method in rules) {
                let rule = {method: method, parameters: rules[method]};
                try {
                    var result = $.validator.methods[method].call(this, element.value.replace(/\r/g, ""), element, rule.parameters);

                    errors[rule.method] = result;

                } catch (e) {
                    console.log(e);
                }
            }
            return errors;
        };

        $form.ajaxForm({
            beforeSubmit: function () {
                showLoading();
            },
            success: function (response) {
                processResponse(response, null, function () {
                    $('.no-passwd', $modal).removeClass('no-passwd');
                    $modal.removeAttr('data-backdrop');
                    $modal.removeAttr('data-keyboard');
                    $modal.modal('hide');
                });
            },
            error: function (param1, param2, param3) {
                notify(param3, 'error', 'Error!');
            },
            complete: function () {
                hideLoading();
            }
        });
    })
    ;
</script>
<?php /**PATH /var/www/html/resources/views/admin/user/change_fiscal_year.blade.php ENDPATH**/ ?>