<?php if (Auth::check() && Auth::user()->can('index.physical.progress.project_tracking.execution')): ?>

<?php $Activity = app('\App\Models\Business\Planning\ActivityProjectFiscalYear'); ?>
<?php $Task = app('\App\Models\Business\Task'); ?>
<?php $ProjectFiscalYear = app('\App\Models\Business\Planning\ProjectFiscalYear'); ?>

<div class="row header-schedule">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <table class="table table-bordered detail-table">
            <tbody>
            <tr>

                <td class="w-25"><?php echo e(trans('projects.labels.project'), false); ?></td>
                <td colspan="2"><?php echo e($project->name, false); ?></td>
            </tr>
            <tr>
                <td class="w-25"><?php echo e(trans('projects.labels.init_date'), false); ?></td>
                <td colspan="2"><?php echo e($project->date_init, false); ?></td>
            </tr>
            <tr>
                <td class="w-25"><?php echo e(trans('projects.labels.end_date'), false); ?></td>
                <td colspan="2"><?php echo e($project->date_end, false); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
        <div class="col-md-6 col-sm-6 col-xs-6 mt-4">
            <div class="col-md-12 col-sm-12 col-xs-12 div-flex">
                <div class="p-1 div-child-flex">
                    <h1 class="m-0"><?php echo e($projectProgress, false); ?> %</h1>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                <h4><?php echo e(trans('physical_progress.labels.currentProgress'), false); ?></h4>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mt-4">
            <div class="col-md-12 col-sm-12 col-xs-12 div-flex">
                <div class="pull-left p-1 div-child-flex">
                    <div class="circle_big bg_red <?php if($semaphore === $ProjectFiscalYear::SEMAPHORE['DELAYED']): ?> o-1 <?php else: ?> o-02 <?php endif; ?>" data-toggle="tooltip" data-placement="top"
                         data-original-title="<?php echo e(trans('physical_progress.labels.delayed'), false); ?>"></div>
                </div>
                <div class="pull-left p-1 div-child-flex">
                    <div class="circle_big bg_orange <?php if($semaphore === $ProjectFiscalYear::SEMAPHORE['AT_RISK']): ?> o-1 <?php else: ?> o-02 <?php endif; ?>" data-toggle="tooltip" data-placement="top"
                         data-original-title="<?php echo e(trans('physical_progress.labels.atRisk'), false); ?>"></div>
                </div>
                <div class="pull-left p-1 div-child-flex">
                    <div class="circle_big bg_green <?php if($semaphore === $ProjectFiscalYear::SEMAPHORE['ONGOING']): ?> o-1 <?php else: ?> o-02 <?php endif; ?>" data-toggle="tooltip" data-placement="top"
                         data-original-title="<?php echo e(trans('physical_progress.labels.ongoing'), false); ?>"></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                <h4><?php echo e(trans('physical_progress.labels.currentStatus'), false); ?></h4>
            </div>
        </div>
    </div>
</div>
<div class="row vertical-align-end">
    <div class="form-group col-md-2">
        <label class="control-label" for="status">
            <?php echo e(trans('physical_progress.labels.activity'), false); ?>

        </label>
        <input type="text" class="form-control  readonly-white" id="activity" value="<?php echo e($filters['activity'], false); ?>">
    </div>

    <div class="form-group col-md-2">
        <label class="control-label" for="status">
            <?php echo e(trans('physical_progress.labels.status'), false); ?>

        </label>
        <select class="form-control" id="status">
            <option value=""><?php echo e(html_entity_decode(trans("app.placeholders.select")), false); ?></option>
            <option value="white" <?php if($filters['state'] == 'white' ): ?> selected <?php endif; ?>><?php echo e(trans('physical_progress.labels.PENDING'), false); ?></option>
            <option value="<?php echo e(\App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['DELAYED'], false); ?>"
                    <?php if($filters['state'] == \App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['DELAYED'] ): ?> selected <?php endif; ?>><?php echo e(trans('physical_progress.labels.delayed'), false); ?></option>
            <option value="<?php echo e(\App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['AT_RISK'], false); ?>"
                    <?php if($filters['state'] == \App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['AT_RISK'] ): ?> selected <?php endif; ?>><?php echo e(trans('physical_progress.labels.atRisk'), false); ?></option>
            <option value="<?php echo e(\App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['ONGOING'], false); ?>"
                    <?php if($filters['state'] == \App\Models\Business\Planning\ActivityProjectFiscalYear::SEMAPHORE['ONGOING'] ): ?> selected <?php endif; ?>><?php echo e(trans('physical_progress.labels.COMPLETED_ONTIME'), false); ?></option>
        </select>
    </div>

    <div class="form-group has-feedback col-md-2">
        <label class="control-label" for="date_from">
            <?php echo e(trans('physical_progress.labels.from'), false); ?>

        </label>
        <input name="date_from" id="date_from" value="<?php echo e($filters['dateFrom'], false); ?>"
               class="form-control has-feedback-left readonly-white picker"
               placeholder=" YYYY-MM-DD" autocomplete="off" readonly/>
        <span class="fa fa-calendar form-control-feedback left mt-2 color-blue" aria-hidden="true"></span>
    </div>

    <div class="form-group has-feedback col-md-2">
        <label class="control-label" for="date_to">
            <?php echo e(trans('physical_progress.labels.to'), false); ?>

        </label>
        <input name="date_init" id="date_to" <?php echo e($filters['dateTo'], false); ?>

        class="form-control has-feedback-left readonly-white picker"
               placeholder=" YYYY-MM-DD" autocomplete="off" readonly/>
        <span class="fa fa-calendar form-control-feedback left mt-2 color-blue" aria-hidden="true"></span>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="search_act"> <?php echo e(trans('app.labels.search'), false); ?></button>
    <button type="button" class="btn btn-default btn-outline mb-3 ml-2" id="clear"> <?php echo e(trans('app.labels.clear'), false); ?></button>
    <div>
        <button id="export_excel" class="btn btn-primary mb-3 ml-2">
            <i class="fa fa-file-excel-o"></i>
            <?php echo e(trans('reports.export.excel'), false); ?>

        </button>
    </div>

</div>
<?php if($projectSchedule->count()): ?>
    <table class="schedule-table" id="schedule_tb">
        <thead id="tableHead">
        <tr>
            <th width="22%" style="text-align: inherit">
                <i class="glyphicon glyphicon-chevron-right arrow_right_all mr-1" role="button"></i>
                <i class="glyphicon glyphicon-chevron-down arrow_down_all mr-1" role="button"></i>
                <?php echo e(trans('physical_progress.labels.task'), false); ?>

            </th>
            <th width="9%"><?php echo e(trans('physical_progress.labels.encoded'), false); ?></th>
            <th width="12%"><?php echo e(trans('physical_progress.labels.startDate'), false); ?></th>
            <th width="12%"><?php echo e(trans('physical_progress.labels.endDate'), false); ?></th>
            <th width="12%"><?php echo e(trans('physical_progress.labels.dueDate'), false); ?></th>
            <th width="12%"><?php echo e(trans('physical_progress.labels.attachmentDate'), false); ?></th>
            <th width="1%"><?php echo e(trans('physical_progress.labels.weight'), false); ?></th>
            <th width="9%"><?php echo e(trans('physical_progress.labels.progress'), false); ?></th>
            <th width="1%"><?php echo e(trans('physical_progress.labels.semaphore'), false); ?></th>
            <th width="10%"><?php echo e(trans('app.labels.actions'), false); ?></th>
        </tr>
        </thead>

        <tbody id="tableBody">

        <?php $__currentLoopData = $projectSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($component['children']) && $component['children']->count()): ?>
                <?php echo $__env->make('business.tracking.projects.physical.loadComponent', ['element' => $component], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(isset($component['children']) && $component['children']->count()): ?>
                <?php $__currentLoopData = $component['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('business.tracking.projects.physical.loadActivity', ['element' => $activity], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if(isset($activity['children']) && $activity['children']->count()): ?>
                        <?php $__currentLoopData = $activity['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('business.tracking.projects.physical.loadTask', ['element' => $task, 'project' => $project, 'currentUser' => $currentUser], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-warning align-center" role="alert">
        <?php echo e(trans('physical_progress.messages.warning.no_info_schedule'), false); ?>

    </div>
<?php endif; ?>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>


    <script>
        $(() => {
            $('#date_from, #date_to').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'es-es',
                useCurrent: false,
                ignoreReadonly: true
            });

            $('#date_from').on('dp.change', (e) => {
                $('#date_to').data('DateTimePicker').minDate(e.date);
            });

            $('#date_to').on('dp.change', (e) => {
                $('#date_from').data('DateTimePicker').maxDate(e.date)
            });

            $("#search_act").click(function () {
                search();
            });

            $("#clear").click(function () {
                $("#date_from").val('');
                $("#date_to").val('');
                $("#status").val('');
                $("#activity").val('');
                search();
            });

            function search() {
                pushRequest(`<?php echo e(route('load_table.physical.progress.project_tracking.execution'), false); ?>`, '#physical_progress_table', () => {
                    $('#load_quarterly').val(1)
                    $('#load_gantt').val(1)
                }, 'GET', {
                    'project_id': '<?php echo e($project->id, false); ?>',
                    'dateFrom': $("#date_from").val(),
                    'dateTo': $("#date_to").val(),
                    'state': $("#status").val(),
                    'activity': $("#activity").val()
                }, false);
            }


            /**
             * Agrega los eventos y acciones para contraer o expandir componentes
             */
            let addArrowEvents = () => {

                // Arrow buttons events
                $(`.arrow_down_all`).on('click', (e) => {
                    $(e.currentTarget).hide();
                    $(e.currentTarget).siblings('.arrow_right_all').show();

                    $(`tr[parent_row='component']`).each((index, element) => {
                        $(element).find('.arrow_down').hide()
                        $(element).find('.arrow_right').show()
                        closeChildren($(element).attr('id'));
                    });
                });

                $(`.arrow_right_all`).on('click', (e) => {
                    $(e.currentTarget).hide();
                    $(e.currentTarget).siblings('.arrow_down_all').show();

                    $(`tr[parent_row='component']`).each((index, element) => {
                        $(element).find('.arrow_down').show()
                        $(element).find('.arrow_right').hide()
                        openChildren($(element).attr('id'));
                    });
                });

            }

            const closeChildren = (id) => {
                $(`tr[parent_row='${id}']`).each((index, element) => {

                    $(element).find('.arrow_down').hide()
                    $(element).find('.arrow_right').show()
                    $(element).hide()

                    closeChildren($(element).attr('id'))
                })
            }

            const openChildren = (id) => {
                $(`tr[parent_row='${id}']`).each((index, element) => {
                    $(element).find('.arrow_down').show()
                    $(element).find('.arrow_right').hide()
                    $(element).show();
                    openChildren($(element).attr('id'));
                })
            }

            $('.arrow_right_all').hide();
            addArrowEvents();

            $('#export_excel').on('click', (e) => {
                e.preventDefault();

                $.ajax({
                    url: '<?php echo e(route('export.physical.progress.project_tracking.execution'), false); ?>',
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        'project_id': '<?php echo e($project->id, false); ?>',
                        'dateFrom': $("#date_from").val(),
                        'dateTo': $("#date_to").val(),
                        'state': $("#status").val(),
                        'activity': $("#activity").val()
                    },
                    beforeSend: () => {
                        showLoading();
                    },
                    success: (response) => {
                        let a = document.createElement('a');
                        let url = window.URL.createObjectURL(response);
                        a.href = url;
                        a.download = '<?php echo e(trans('physical_progress.title'), false); ?>';
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    }
                }).always(() => {
                    hideLoading();
                }).fail(function() {
                    hideLoading();
                });
            });
        })
    </script><?php /**PATH /var/www/html/resources/views/business/tracking/projects/physical/loadTable.blade.php ENDPATH**/ ?>