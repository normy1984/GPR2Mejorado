<?php if (Auth::check() && Auth::user()->can('edit.project.plan_elements.plans.plans_management')): ?>
<?php $Project = app('\App\Models\Business\Project'); ?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="align-center"><?php echo e(trans('projects.labels.edit'), false); ?></h2>

        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
                <form role="form" method="post"
                      enctype="multipart/form-data"
                      class="form-horizontal form-label-left" id="projectFormEdit">

                    <?php echo method_field('POST'); ?>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="1" name="edit_budget">
                    <div class="pb-4"><?php echo $route; ?></div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="project_name">
                            <?php echo e(trans('plan_elements.labels.project_name'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="name" id="project_name" maxlength="200"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   placeholder="<?php echo e(trans('projects.placeholders.name'), false); ?>" autocomplete="off"
                                   value="<?php echo e($entity->name, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="cup">
                            <?php echo e(trans('projects.labels.cup'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" name="cup" id="cup" maxlength="3"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   placeholder="<?php echo e(trans('projects.placeholders.cup'), false); ?>" autocomplete="off"
                                   value="<?php echo e($entity->cup, false); ?>" disabled/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="description">
                            <?php echo e(trans('plan_elements.labels.description'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea name="description" id="description" class="form-control"><?php echo e($entity->description, false); ?></textarea>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="is_road">
                            <?php echo e(trans('plan_elements.labels.isRoad'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" name="is_road" id="is_road" class="js-switch" <?php if($entity->is_road): ?> checked <?php endif; ?>/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="responsible_unit_id">
                            <?php echo e(trans('plan_elements.labels.responsibleUnit'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control select2 select2_type" id="responsible_unit_id" name="responsible_unit_id"
                                    <?php if(in_array($entity->status, [$Project::STATUS_IN_PROGRESS])): ?>
                                    disabled
                                    <?php endif; ?> >
                                <option value=""><?php echo e(trans('app.labels.select'), false); ?></option>
                                <?php $__currentLoopData = $responsibleUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id, false); ?>" <?php if($entity->responsible_unit_id == $value->id): ?> selected <?php endif; ?> ><?php echo e($value->name, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="zone">
                            <?php echo e(trans('projects.labels.zone'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="zone" id="zone" maxlength="100"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   placeholder="<?php echo e(trans('projects.placeholders.zone'), false); ?>" autocomplete="off"
                                   value="<?php echo e($entity->zone, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="date_init">
                            <?php echo e(trans('projects.labels.init_date'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?php if(!$inProgress): ?>
                                <input name="date_init" id="date_init"
                                       class="form-control has-feedback-left readonly-white"
                                       placeholder=" DD-MM-YYYY" autocomplete="off" readonly
                                       value="<?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?>"/>
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <?php else: ?>
                                <label class="mt-2"><?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?></label>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="date_end">
                            <?php echo e(trans('projects.labels.end_date'), false); ?> <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?php if(!$inProgress || !$endDateDisable): ?>
                                <input name="date_end" id="date_end"
                                       class="form-control has-feedback-left readonly-white"
                                       placeholder=" DD-MM-YYYY" autocomplete="off" readonly
                                       value="<?php echo e(date('d-m-Y', strtotime($entity->date_end)), false); ?>"/>
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <?php else: ?>
                                <label class="mt-2"><?php echo e(date('d-m-Y', strtotime($entity->date_end)), false); ?></label>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="month_duration">
                            <?php echo e(trans('projects.labels.month_duration'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="month_duration" id="month_duration" maxlength="100"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   disabled
                                   value="<?php echo e($entity->month_duration, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="execution_term">
                            <?php echo e(trans('projects.labels.execution_term'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="execution_term" id="execution_term" maxlength="100"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   disabled
                                   value="<?php echo e($entity->execution_term, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="tir">
                            <?php echo e(trans('projects.labels.tir'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="tir" id="tir"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   value="<?php echo e($entity->tir, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="van">
                            <?php echo e(trans('projects.labels.van'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input name="van" id="van"
                                   class="form-control col-md-7 col-sm-7 col-xs-12"
                                   value="<?php echo e($entity->van, false); ?>"/>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="benefit_cost">
                            <?php echo e(trans('projects.labels.benefit_cost'), false); ?>

                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea name="benefit_cost" id="benefit_cost"
                                      class="form-control col-md-7 col-sm-7 col-xs-12"
                                      placeholder="<?php echo e(trans('projects.placeholders.benefit_cost'), false); ?>"><?php echo e($entity->benefit_cost, false); ?></textarea>
                        </div>
                    </div>

                    <fieldset id="budgets_fieldset" class="mt-5">
                        <legend class="scheduler-border"><?php echo e(trans('projects.labels.annual_budgets'), false); ?></legend>
                        <div id="load_annual_budgets">

                        </div>

                        <div class="item form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="referential_budget">
                                <?php echo e(trans('projects.labels.referential_budget'), false); ?>

                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php if(!$inProgress): ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input name="referential_budget" id="referential_budget" maxlength="100"
                                               class="form-control col-md-7 col-sm-7 col-xs-12"
                                               disabled
                                               value="<?php echo e($entity->referential_budget, false); ?>"/>
                                    </div>
                                <?php else: ?>
                                    <label class="mt-2" id="referential_budget">$ <?php echo e($entity->referential_budget, false); ?></label>
                                <?php endif; ?>
                            </div>
                        </div>

                    </fieldset>

                    <div class="pull-right">
                        <button id="cancelBtn" type="button" class="btn btn-info"><i class="fa fa-times"></i> <?php echo e(trans('app.labels.cancel'), false); ?></button>
                        <button id="submitBtn" class="btn btn-success"><i class="fa fa-check"></i> <?php echo e(trans('app.labels.save'), false); ?> <?php echo e(trans('plan_elements.labels.PROJECT'), false); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(() => {

        /**
         * Obtiene la diferencia en meses
         *
         * @param dt2
         * @param dt1
         * @returns {*|string}
         */
        const diff_months = (dt2, dt1) => {
            let end = moment(dt2, "DD-MM-YYYY");
            let init = moment(dt1, "DD-MM-YYYY");
            return end.diff(init, 'months', true).toFixed(2);
        };

        /**
         * Obtiene la diferencia en años
         *
         * @param dt2
         * @param dt1
         * @returns {number}
         */
        const diff_years = (dt2, dt1) => {
            let end = moment(dt2, "DD-MM-YYYY");
            let init = moment(dt1, "DD-MM-YYYY");
            return end.year() - init.year();
        };

        let $form = $('#projectFormEdit');

        /**
         * Agrega validaciones y lógica a cada campo de presupuesto anual
         */
        const addBudgetsLogic = () => {

            /**
             * Almacena la acción que se va a ejecutar ante un evento sobre el campo
             */
            const action = () => {
                let referential_budget = parseFloat("<?php echo e($entity->referential_budget, false); ?>");
                $('input[id*="budgets"]').each((index, element) => {
                    referential_budget = referential_budget + parseFloat($(element).val() || 0)
                });
                $('#referential_budget').text(referential_budget).number(true, 2).text(`$ ${$('#referential_budget').text()}`);
            };

            $('input[id*="budgets"]').on('focusin', (e) => {
                $(e.currentTarget).attr('maxlength', 16)
            });

            $('input[id*="budgets"]').each((index, element) => {
                $(element).number(true, 2);
                $(element).rules("add", {
                    required: true,
                    min: 0,
                    max: <?php echo e($Project::MAX_ALLOWED_VALUE, false); ?>,
                    messages: {
                        max: '<?php echo e(trans('plan_elements.messages.validations.maxValue'), false); ?>'
                    }
                });

                $(element).change(() => {
                    action()
                });

                $(element).keyup(() => {
                    action()
                })
            });

            action()
        };

        $('#budgets_fieldset').hide();

        $('#cancelBtn').click(() => {
            $('#load-area').empty();

            $('li').each((index, element) => {
                $(element).removeClass('treeview-item-selected')
            })
            $('i').each((index, element) => {
                $(element).removeClass('treeview-action-item-selected')
            })
        })

        pushRequest('<?php echo e(route('loadannualbudgets.edit.project.plan_elements.plans.plans_management'), false); ?>', '#load_annual_budgets', function () {
            $('#budgets_fieldset').slideDown();
            addBudgetsLogic();
            $('#referential_budget').number(true, 2)
        }, 'GET', {
            'years': diff_years('<?php echo e(date('d-m-Y', strtotime($entity->date_end)), false); ?>', '<?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?>'),
            'project_id': <?php echo e($entity->id, false); ?>,
            'inProgress': <?php echo e($inProgress ?: 0, false); ?>

        }, false);

        <?php if(!$inProgress): ?>
        // Add datetimepicker
        $(`#date_init, #date_end`).datetimepicker({
            format: 'DD-MM-YYYY',
            locale: 'es-es',
            useCurrent: false,
            ignoreReadonly: true,
            minDate: moment('<?php echo e($minDate, false); ?>', 'DD-MM-YYYY').millisecond(0).second(0).minute(0).hour(0),
            maxDate: moment('<?php echo e($maxDate, false); ?>', 'DD-MM-YYYY').millisecond(0).second(59).minute(59).hour(23)
        });

        if ($(`#date_end`).val()) {
            $(`#date_init`).data('DateTimePicker').maxDate(moment($(`#date_end`).val(), 'DD-MM-YYYY'))
        }

        if ($(`#date_init`).val()) {
            $(`#date_end`).data('DateTimePicker').minDate(moment($(`#date_init`).val(), 'DD-MM-YYYY'))
        }

        $(`#date_init, #date_end`).on('dp.hide', (e) => {
            setTimeout(() => {
                $(e.currentTarget).data('DateTimePicker').viewDate(moment('<?php echo e($minDate, false); ?>', 'DD-MM-YYYY').millisecond(0).second(0).minute(0).hour(0))
            }, 1);
        });

        $(`#date_init`).on('dp.change', (e) => {
            $(`#date_end`).data('DateTimePicker').minDate(e.date)

            if ($(e.currentTarget).val() && $(`#date_end`).val()) {
                $('#referential_budget').val('');

                let values = $('input[name*="budgets"]').map((index, element) => {
                    return $(element).val();
                }).get();

                pushRequest('<?php echo e(route('loadannualbudgets.create.project.plan_elements.plans.plans_management'), false); ?>', '#load_annual_budgets', () => {
                    $('#budgets_fieldset').slideDown()
                    addBudgetsLogic()
                }, 'GET', {
                    'years': diff_years($(`#date_end`).val(), $(e.currentTarget).val()),
                    'values': values,
                    'inProgress': <?php echo e($inProgress ?: 0, false); ?>

                }, false);

                $('#month_duration').val(diff_months($(`#date_end`).val(), $(e.currentTarget).val()));
                $('#execution_term').val(diff_years($(`#date_end`).val(), $(e.currentTarget).val()) > 0 ? '<?php echo e($Project::EXECUTION_TERM_PLURIANNUAL, false); ?>' : '<?php echo e($Project::EXECUTION_TERM_ANNUAL, false); ?>');
            }
        });

        $(`#date_end`).on('dp.change', (e) => {
            $(`#date_init`).data('DateTimePicker').maxDate(e.date)

            if ($(`#date_init`).val() && $(e.currentTarget).val()) {
                $('#referential_budget').val('');

                let values = $('input[name*="budgets"]').map((index, element) => {
                    return $(element).val();
                }).get();

                pushRequest('<?php echo e(route('loadannualbudgets.create.project.plan_elements.plans.plans_management'), false); ?>', '#load_annual_budgets', () => {
                    $('#budgets_fieldset').slideDown()
                    addBudgetsLogic()
                }, 'GET', {
                    'years': diff_years($(e.currentTarget).val(), $(`#date_init`).val()),
                    'values': values,
                    'inProgress': <?php echo e($inProgress ?: 0, false); ?>

                }, false);

                $('#month_duration').val(diff_months($(e.currentTarget).val(), $(`#date_init`).val()));
                $('#execution_term').val(diff_years($(e.currentTarget).val(), $(`#date_init`).val()) > 0 ? '<?php echo e($Project::EXECUTION_TERM_PLURIANNUAL, false); ?>' : '<?php echo e($Project::EXECUTION_TERM_ANNUAL, false); ?>');
            }
        });
        <?php elseif(!$endDateDisable): ?>

        $('#date_end').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: 'es-es',
            useCurrent: false,
            ignoreReadonly: true,
            minDate: moment('<?php echo e($minDate, false); ?>', 'DD-MM-YYYY').millisecond(0).second(0).minute(0).hour(0),
            maxDate: moment('<?php echo e($maxDate, false); ?>', 'DD-MM-YYYY').millisecond(0).second(59).minute(59).hour(23)

        });

        $('#date_end').on('dp.change', (e) => {

            if ($(e.currentTarget).val()) {
                $('#referential_budget').text('');

                let values = $('input[name*="budgets"]').map((index, element) => {
                    return $(element).val();
                }).get();

                pushRequest('<?php echo e(route('loadannualbudgets.create.project.plan_elements.plans.plans_management'), false); ?>', '#load_annual_budgets', () => {
                    $('#budgets_fieldset').slideDown();
                    addBudgetsLogic()
                }, 'GET', {
                    'years': diff_years($(e.currentTarget).val(), "<?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?>"),
                    'project_id': '<?php echo e($entity->id, false); ?>',
                    'values': values,
                    'inProgress': '<?php echo e($inProgress ?: 0, false); ?>',
                    'newYears': diff_years($(e.currentTarget).val(), "<?php echo e(date('d-m-Y', strtotime($entity->date_end)), false); ?>")
                }, false);

                $('#month_duration').val(diff_months($(e.currentTarget).val(), "<?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?>"));
                $('#execution_term').val(diff_years($(e.currentTarget).val(), "<?php echo e(date('d-m-Y', strtotime($entity->date_init)), false); ?>") > 0 ? '<?php echo e($Project::EXECUTION_TERM_PLURIANNUAL, false); ?>' : '<?php echo e($Project::EXECUTION_TERM_ANNUAL, false); ?>');
            }
        });

        <?php endif; ?>

            $validateDefaults.rules = {
            name: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            cup: {
                required: true,
                maxlength: 3,
                digits: true,
                remote: {
                    url: "<?php echo route('checkuniquefield'); ?>",
                    async: false,
                    data: {
                        fieldName: 'cup',
                        fieldValue: () => {
                            return $('#cup').val();
                        },
                        model: 'App\\Models\\Business\\Project',
                        current: '<?php echo e($entity ->id, false); ?>',
                        filter: {
                            plan_element_id: '<?php echo e($planElementId, false); ?>'
                        }
                    }
                }
            },
            description: {
                required: true
            },
            zone: {
                required: true,
                maxlength: 100
            },
            date_init: {
                required: true
            },
            date_end: {
                required: true
            },
            tir: {
                required: false,
                maxlength: 14,
                number: true,
                onlyTwoDecimal: true
            },
            van: {
                required: false,
                maxlength: 14,
                number: true,
                onlyTwoDecimal: true
            },
            benefit_cost: {
                required: false
            }
        };

        // Validar que solo tenga 2 decimales
        jQuery.validator.addMethod("onlyTwoDecimal", (value) => {
            let RE = /^-?\d*(\.\d{1})?\d{0,1}$/;
            if (RE.test(value)) {
                return true;
            } else {
                return false;
            }
        }, '<?php echo e(trans('projects.messages.errors.only_two_decimal'), false); ?>');

        $validateDefaults.messages = {
            cup: {
                remote: '<?php echo e(trans('projects.messages.validation.project_cup_exists'), false); ?>'
            }
        };

        $form.validate($validateDefaults);

        $('#submitBtn').click((e) => {
            e.preventDefault()

            if ($form.valid()) {

                let url = "<?php echo route('update.edit.project.plan_elements.plans.plans_management', ['id' => $entity->id]); ?>";
                let formData = new FormData($form[0]);

                formData.append('plan_element_id', <?php echo e($planElementId, false); ?>)

                let callback = (data = null, options = null) => {
                    pushRequest(url, null, () => {
                        $('#load-area').empty();
                        $('#load-tree').empty();

                        const url = '<?php echo route('loadstructure.edit.plans.plans_management', ['id' => $planId]); ?>'
                        pushRequest(url, '#load-tree', () => {
                        }, 'GET', {'_token': '<?php echo csrf_token(); ?>'}, false);

                    }, 'POST', data || formData, false, options || {form: true});
                };

                <?php if(isset($justifiable) && $justifiable): ?>
                justificationModalMultiple(callback, formData, null, '<?php echo e(trans('justifications.actions.update'), false); ?>', true);
                <?php else: ?>
                callback();
                <?php endif; ?>

            }
        })

    });

</script>

<?php endif; ?><?php /**PATH /var/www/html/resources/views/business/planning/plan_element/project/update.blade.php ENDPATH**/ ?>