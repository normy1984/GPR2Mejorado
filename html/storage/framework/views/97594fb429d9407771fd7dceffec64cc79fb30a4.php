<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><?php echo e(trans('current_expenditure.labels.import'), false); ?></h4>
    </div>

    <div class="modal-body">
        <form role="form" action="<?php echo e(route('import.current_expenditure_elements.budget.plans_management'), false); ?>"
              method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" id="import-fm">
            <?php echo method_field('POST'); ?>
            <?php echo csrf_field(); ?>

            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="files">
                <?php echo e(trans('attachments.labels.select_file'), false); ?>

            </label>
            <div class="col-md-5 col-sm-6 col-xs-7 pl-0">
                <div class="col-md-11 col-sm-11 col-xs-11">
                    <input type="file" name="file" id="files" class="form-control"
                           accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 pl-0">
                    <i role="button" data-toggle="tooltip" data-placement="right"
                       data-original-title="<?php echo e(trans('income.labels.formats'), false); ?>"
                       class="fa fa-info-circle fa-tooltip blue"></i>
                </div>
            </div>
        </form>

        <div class="alert alert-danger fw-b mt-3" role="alert">
            <?php echo e(trans('current_expenditure.messages.confirm.import'), false); ?>

        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">
            <i class="fa fa-times"></i> <?php echo e(trans('app.labels.cancel'), false); ?>

        </button>
        <button class="btn btn-success" id="submit-fm" data-dismiss="modal">
            <i class="fa fa-cloud-upload"></i> <?php echo e(trans('income.labels.import'), false); ?>

        </button>
    </div>
</div>

<script>
    $(() => {
        let $form = $('#import-fm');
        $form.validate($validateDefaults);
        $form.ajaxForm($formAjaxDefaults);
        $('#submit-fm').on('click', () => {
            if ($form.valid()) {
                $form.submit();
            }
        });
    })
</script><?php /**PATH /var/www/html/resources/views/business/planning/current_expenditure/import.blade.php ENDPATH**/ ?>