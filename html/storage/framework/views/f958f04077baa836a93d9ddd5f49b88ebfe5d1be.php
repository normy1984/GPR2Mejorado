<?php if (Auth::check() && Auth::user()->can('budget_card.reports')): ?>
<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel mb-15">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-list-alt"></i> <?php echo e(trans('reports.budget_card.title'), false); ?>

                    </h2>

                    <?php if (Auth::check() && Auth::user()->can('export.budget_card.reports')): ?>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a id="export_excel" class="btn pdf-export-button">
                                <i class="fa fa-file-excel-o"></i><?php echo e(trans('reports.export.excel'), false); ?>

                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content mb-15">
                    <div class="row">
                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="budget_type">
                                <?php echo e(trans('reports.budget_card.type'), false); ?>

                            </label>
                            <div class="btn-group mb-2" data-toggle="buttons">
                                <label class="btn btn-default active">
                                    <input type="radio" name="budget_type" checked
                                           value="1"> <?php echo e(trans('reports.budget_card.type_expense'), false); ?>

                                </label>
                                <label class="btn btn-default">
                                    <input type="radio" name="budget_type"
                                           value="2"> <?php echo e(trans('reports.budget_card.type_income'), false); ?>

                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="level">
                                <?php echo e(trans('reports.budget_card.level'), false); ?>

                            </label>
                            <select class="form-control select2" id="level">
                                <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($level['niv_est'], false); ?>" <?php if($loop->last): ?> selected <?php endif; ?>><?php echo e($level['niv_est'], false); ?> - <?php echo e($level['des_est'], false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="view_children">
                                <?php echo e(trans('reports.budget_card.view_children'), false); ?>

                            </label>
                            <div class="mt-3 mb-2">
                                <?php echo e(trans('reports.labels.no'), false); ?> <input type="checkbox" name="view_children"
                                                                        id="view_children"
                                                                        class="js-switch"/> <?php echo e(trans('reports.labels.yes'), false); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="year">
                                <?php echo e(trans('reports.budget_card.year'), false); ?>

                            </label>
                            <select class="form-control" id="year">
                                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($year->year, false); ?>"
                                            <?php if($year->year == $currentYear): ?> selected <?php endif; ?> ><?php echo e($year->year, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="date">
                                <?php echo e(trans('reports.budget_card.date'), false); ?>

                            </label>
                            <div class="input-group mb-0">
                                <input type="text" class="form-control picker readonly-white" id="date"
                                       autocomplete="off" readonly value="<?php echo e($currentDate, false); ?>">
                                <span class="input-group-addon clear-selection">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12 text-center mt-4">
                            <button class="btn btn-success mb-0" id="search"><?php echo e(trans('app.labels.search'), false); ?></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-2 col-xs-12" id="filter_unit">
                            <label class="control-label" for="executing_unit">
                                <?php echo e(trans('reports.budget_card.executing_unit'), false); ?>

                            </label>
                            <select class="form-control select2" id="executing_unit">
                                <option value=""><?php echo e(trans('app.labels.select'), false); ?></option>
                                <?php $__currentLoopData = $executingUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unit->code, false); ?>"><?php echo e($unit->code . ' - ' . $unit->name, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="search-box" class="form-control search_box"
                                   placeholder="Buscar por Código ó Nombre...">
                        </div>
                    </div>
                    <table class="table report-table" id="budget_card">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php echo e(trans('reports.budget_card.item'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.name'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.assigned'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.reform'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.encoded'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.certified'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.committed'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.accrued'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.by_committed'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.by_accrued'), false); ?></th>
                            <th><?php echo e(trans('reports.budget_card.paid'), false); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="navbar-default navbar-fixed-bottom text-center">
    <a id="cancelLinks" href="<?php echo e(route('index.reports'), false); ?>"
       class="btn btn-info ajaxify"><?php echo e(trans('app.labels.backward'), false); ?>

    </a>
</footer>
<script>
    $(() => {
        let datatable = build_datatable($('#budget_card'), {
            dom: '<t>ir',
            ajax: {
                url: '<?php echo route('data.budget_card.reports'); ?>',
                "data": (d) => {
                    return $.extend({}, d, {
                        year: $('#year').val(),
                        date: $('#date').val(),
                        type: $('input[type=radio][name=budget_type]:checked').val(),
                        level: $('#level').val(),
                        view_children: $('input[type=checkbox][name=view_children]:checked').val(),
                        executing_unit: $('#executing_unit').val()
                    });
                },
                "dataSrc": function (response) {
                    if (response.exception !== '') {
                        notify(response.exception, 'warning')
                    }
                    return response.data;
                }
            },
            paging: false,
            responsive: false,
            scrollX: true,
            scrollY: '400px',
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false},
                {data: 'cuenta', width: '15%', sortable: false},
                {data: 'nom_cue', width: '30%', sortable: false},
                {data: 'asig_ini', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'reformas', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'codificado', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'certificado', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'comprometido', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'devengado', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'por_comprometer', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'por_devengar', width: '5%', sortable: false, searchable: false, class: "text-center"},
                {data: 'pagado', width: '5%', sortable: false, searchable: false, class: "text-center"},
            ],
            initComplete: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            drawCallback: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
        });
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'es-es',
            ignoreReadonly: true,
            minDate: moment($('#year').val() + "-01-01", "YYYY-MM-DD"),
            maxDate: moment($('#year').val() + "-12-31", "YYYY-MM-DD")
        });

        $('.select2').select2({});
        $('#year').select2({}).on('change', () => {
            $('#date').data('DateTimePicker').destroy();
            $('#date').datetimepicker(
                {
                    format: 'YYYY-MM-DD',
                    locale: 'es-es',
                    date: moment($('#year').val() + "-12-31", "YYYY-MM-DD"),
                    ignoreReadonly: true,
                    minDate: moment($('#year').val() + "-01-01", "YYYY-MM-DD"),
                    maxDate: moment($('#year').val() + "-12-31", "YYYY-MM-DD")
                }
            );
            let d = new Date();
            $('#date').val($('#year').val() + '-' + d.getMonth().toString().padStart(2, "0") + '-' + d.getDay().toString().padStart(2, "0"));
        });

        $('#search').on('click', () => {
            datatable.draw();
        });

        $('#search-box').on('keyup', () => {
            datatable.search($('#search-box').val()).draw();
        });

        $('input[type=radio][name=budget_type]').on('change', () => {
            $('#level').html('');
            let url = '<?php echo e(route('levels.budget_card.reports', ['year' => '__YEAR__', 'type' => '__TYPE__']), false); ?>';
            url = url.replace('__YEAR__', $('#year').val());
            url = url.replace('__TYPE__', $('input[type=radio][name=budget_type]:checked').val());
            pushRequest(url, null, (response) => {
                let opt = [];
                $.each(response, (index, value) => {
                    opt.push({
                        id: value.niv_est,
                        text: value.niv_est + ' - ' + value.des_est,
                    });
                });

                $('#level').select2({
                    data: opt
                });
                if (opt.length > 0) {
                    $('#level').val($(opt).last()[0].id); // Select the last option level
                    $('#level').trigger('change');
                }
            }, 'get', null, false);

            if ($('input[type=radio][name=budget_type]:checked').val() == 1) {
                $('#filter_unit').show()
            } else {
                $('#filter_unit').hide()
            }

        });

        $('#export_excel').on('click', (e) => {
            e.preventDefault();
            $.ajax({
                url: '<?php echo e(route('export.budget_card.reports'), false); ?>',
                method: 'GET',
                data: {
                    year: $('#year').val(),
                    date: $('#date').val(),
                    type: $('input[type=radio][name=budget_type]:checked').val(),
                    level: $('#level').val(),
                    levelDescription: $('#level :selected').text(),
                    view_children: $('input[type=checkbox][name=view_children]:checked').val(),
                    item: $('#search-box').val(),
                    executing_unit: $('#executing_unit').val()
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: (response) => {
                    let a = document.createElement('a');
                    let url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = '<?php echo e(trans('reports.budget_card.report_file_name'), false); ?>';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });
        });

        $('.clear-selection').on('click', () => {
            $('.picker').datetimepicker('show');
        });

        /**
         * Ajusta tamaño de headers y footers de la tabla cuando se redimensiona la pantalla
         */
        $(window).resize(() => {
            $('#budget_card').DataTable().columns.adjust()
            $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
        })
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/reports/tracking/budget_card/budget_card.blade.php ENDPATH**/ ?>