<!-- Justification Modal -->
<div class="modal fade" id="justificationModalMultiple" tabindex="-1" role="dialog" aria-labelledby="justificationTitleMultiple">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="justificationTitleMultiple"><i class="fa fa-file-text"></i> <?php echo e(trans('justifications.labels.create'), false); ?></h4>
            </div>

            <div class="modal-body">

                <p id="infoMultiple" class="text-center mt-3 ml-3 mr-3"><?php if(isset($info)): ?><?php echo e($info, false); ?><?php endif; ?></p>
                <hr>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <?php if(isset($form) && $form): ?>
                        <form role="form" class="form-horizontal form-label-left" id="justificationFormMultiple" novalidate>
                        <?php endif; ?>

                            <input type="hidden" name="actionMultiple" id="actionMultiple" value="<?php if(isset($action)): ?><?php echo e($action, false); ?><?php endif; ?>"/>
                            <input type="hidden" name="justifiableMultiple" id="justifiableMultiple" value="true"/>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="justificationDescriptionMultiple">
                                    <?php echo e(trans('justifications.labels.description'), false); ?> <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea name="justificationDescriptionMultiple" id="justificationDescriptionMultiple" maxlength="500" rows="4"
                                          class="form-control vertical"></textarea>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="justificationFileMultiple">
                                    <?php echo e(trans('justifications.labels.file'), false); ?>

                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-11">
                                    <input type="file" name="justificationFileMultiple" id="justificationFileMultiple"
                                           class="form-control"
                                           accept="application/pdf"
                                           data-rule-required="true"
                                           data-msg-accept="<?php echo e(trans('justifications.messages.validations.file_extension'), false); ?>"/>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1 pl-0">
                                    <i role="button" data-toggle="tooltip" data-placement="right"
                                       data-original-title="<?php echo e(trans('justifications.messages.info.abbreviation'), false); ?>"
                                       class="fa fa-info-circle fa-tooltip blue"></i>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="justificationDocumentReferenceMultiple">
                                    <?php echo e(trans('justifications.labels.document_reference'), false); ?>

                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="justificationDocumentReferenceMultiple" id="justificationDocumentReferenceMultiple"
                                           class="form-control" maxlength="50"/>
                                </div>
                            </div>

                        <?php if(isset($form) && $form): ?>
                        </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo e(trans('justifications.labels.dismiss'), false); ?>

                </button>
                <?php if(isset($type) && $type == 'submit'): ?>
                    <button id="justifyMultiple" name="justifyMultiple" type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> <?php echo e(trans('justifications.labels.save'), false); ?>

                    </button>
                <?php else: ?>
                    <button id="justifyMultiple" name="justifyMultiple" type="button" class="btn btn-success" data-dismiss="modal">
                        <i class="fa fa-check"></i> <?php echo e(trans('justifications.labels.save'), false); ?>

                    </button>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php if(isset($form) && $form): ?>
<script>
    var justificationFormMultiple = $('#justificationFormMultiple');

    $validateDefaults.rules = {
        justificationDescriptionMultiple: {
            required: true,
            maxlength: 500
        },
        justificationFileMultiple: {
            required: true,
            extension: 'pdf'
        },
        justificationDocumentReferenceMultiple: {
            required: true,
            maxlength: 50
        }
    };

    justificationFormMultiple.validate($validateDefaults);
    justificationFormMultiple.ajaxForm($formAjaxDefaults);

    // Abrir el modal de justificación cuyo comportamiento corresponde a los parámetros enviados.
    function justificationModalMultiple (callback, data, message = null, action = null, form = false) {
        $('#justifyMultiple').unbind('click');

        if(message) {
            $('#infoMultiple').html(message);
        }

        if(action) {
            $('#actionMultiple').val(action);
        }
        $('#justificationModalMultiple').modal('toggle');

        $('#justifyMultiple').click((e) => {
            e.preventDefault();

            if (!justificationFormMultiple.valid()) {
                return false;
            }

            let formData = new FormData($('#justificationFormMultiple')[0]);

            if (form){
                for (var field of data.entries()) {
                    formData.append(field[0], field[1]);
                }
            } else {
                for (const key of Object.keys(data)) {
                    formData.append(key, data[key]);
                }
            }

            callback(formData, {file: true});
            justificationFormMultiple.trigger("reset");
        });
    }
</script>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/business/planning/partials/justification/form_multiple.blade.php ENDPATH**/ ?>