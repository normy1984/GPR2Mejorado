<?php if (Auth::check() && Auth::user()->can('poa_tracking_physical_and_budget.reports')): ?>

<div>
    <div class="page-title pt-0">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-11 col-sm-11 col-xs-11">
                <h3><?php echo e(trans('app.labels.reports'), false); ?></h3>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel mb-15">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-list-alt"></i> <?php echo e(trans('poa_tracking.labels.POA'), false); ?>

                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <?php if (Auth::check() && Auth::user()->can('export_xls.poa_tracking_physical_and_budget.reports')): ?>
                        <li class="pull-right">
                            <a id="export_excel" class="btn pdf-export-button" href=""><i
                                    class="fa fa-file-excel-o"></i> <?php echo e(trans('reports.export.excel'), false); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (Auth::check() && Auth::user()->can('export_pdf.poa_tracking_physical_and_budget.reports')): ?>
                        <li class="pull-right">
                            <a id="export_pdf" class="btn ajaxify pdf-export-button">
                                <i class="fa fa-file-pdf-o"></i><?php echo e(trans('poa_tracking.messages.export.pdf'), false); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="row">
                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="year">
                                <?php echo e(trans('reports.labels.select_year'), false); ?>

                            </label>
                            <?php if(count($years)): ?>
                                <select class="form-control select2" id="years" name="years">
                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($year->id, false); ?>" <?php if($year->year == $currentYear): ?> selected <?php endif; ?> ><?php echo e($year->year, false); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2 col-xs-12" id="filter_unit">
                                <label class="control-label" for="executing_unit">
                                    <?php echo e(trans('reports.budget_card.executing_unit'), false); ?>

                                </label>
                                <select class="form-control select2" id="executing_unit">
                                    <option value="0"><?php echo e(trans('app.labels.all'), false); ?></option>
                                    <?php $__currentLoopData = $executingUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($unit->id, false); ?>"><?php echo e($unit->code . ' - ' . $unit->name, false); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table class="table report-table" id="poa_tb">
                        <thead>
                        <tr>
                            <th><?php echo e(trans('poa_tracking.labels.executing_unit'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.project'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.component'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.activity'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.responsible'), false); ?></th>
                            <th><?php echo e(trans('app.headers.date_init'), false); ?></th>
                            <th><?php echo e(trans('app.headers.date_end'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.codificado'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.por_comprometer'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.physical_progress'), false); ?></th>
                            <th><?php echo e(trans('poa_tracking.labels.budget_progress'), false); ?></th>
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

        $('.select2').select2({});

        let yearSelected = $("#years").val();
        let unitSelected = parseInt($("#executing_unit").val());

        let export_url = '<?php echo e(route('export_xls.poa_tracking_physical_and_budget.reports', ['fiscalYearId' => '__FISCAL_YEAR__', 'executingUnitId' => '__UNIT_ID__']), false); ?>';
        export_url = export_url.replace('__FISCAL_YEAR__', yearSelected).replace('__UNIT_ID__', unitSelected);
        $('#export_excel').attr('href', export_url);

        let dataTable = build_datatable($('#poa_tb'), {
            dom: 'tr',
            ajax: {
                url: '<?php echo route('data.poa_tracking_physical_and_budget.reports'); ?>',
                "dataSrc": (response) => {
                    if (response.exception !== '') {
                        notify(response.exception, 'warning')
                    }
                    return response.data;
                },
                "data": (d) => {
                    return $.extend({}, d, {
                        "fiscalYearId": $('#years').val(),
                        "executingUnitId": $('#executing_unit').val()
                    });
                }
            },
            paging: false,
            responsive: false,
            scrollX: true,
            scrollY: '600px',
            columns: [
                {data: 'department_name', width: '15%', sortable: false, searchable: false},
                {data: 'project_name', width: '15%', sortable: false, searchable: false},
                {data: 'component_name', width: '15%', sortable: false, searchable: false},
                {data: 'name', width: '15%', sortable: false, searchable: false},
                {data: 'responsible', width: '15%', sortable: false, searchable: false},
                {data: 'date_init', width: '10%', sortable: false, searchable: false},
                {data: 'date_end', width: '10%', sortable: false, searchable: false},
                {data: 'codificado', width: '10%', sortable: false, searchable: false},
                {data: 'por_comprometer', width: '10%', sortable: false, searchable: false},
                {data: 'physical_progress', width: '10%', sortable: false, searchable: false},
                {data: 'budget_progress', width: '10%', sortable: false, searchable: false},
            ],
            initComplete: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            drawCallback: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            rowsGroup: [0, 1, 2]
        })

        let logoBase64;

        imgToBase64('<?php echo e(mix('images/logo_login.png'), false); ?>', function (base64) {
            logoBase64 = base64;
        });

        $('#export_pdf').on('click', () => {
            let startYTable = 70, totalPagesExp = "{total_pages_count_string}";
            let doc = new jsPDF('l', 'mm', 'a3');

            doc.autoTable({
                html: '#poa_tb',
                theme: 'grid',
                tableWidth: 'auto',
                headStyles: {
                    halign: 'center'
                },
                styles: {
                    overflow: 'linebreak',
                    cellWidth: 'auto',
                    valign: 'middle',
                    minCellWidth: 20
                },
                columnStyles: {
                    0: {cellWidth: 50},
                    6: {cellWidth: 30}
                },
                didDrawPage: (data) => {
                    doc = setDocHeaderAndFooter(data, doc, logoBase64, `<?php echo e(trans('poa_tracking.labels.POA'), false); ?> - ${$('#years option:selected').text()}`, '<?php echo e($gad, false); ?>',
                        `<?php echo e(trans('app.labels.date'), false); ?>: ${moment().format('DD/MM/YYYY')}    <?php echo e(trans('poa_tracking.labels.executing_unit'), false); ?>: ${$('#executing_unit option:selected').text()}`,
                        totalPagesExp);
                },
                margin: {top: startYTable}
            });

            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }

            doc.save('<?php echo e(trans('poa_tracking.labels.POA'), false); ?>' + '.pdf')
        })

        $("#years").on('change', () => {

            let yearSelected = parseInt($("#years").val());
            let unitSelected = parseInt($("#executing_unit").val());

            let export_url = '<?php echo e(route('export_xls.poa_tracking_physical_and_budget.reports', ['fiscalYearId' => '__FISCAL_YEAR__', 'executingUnitId' => '__UNIT_ID__']), false); ?>';
            export_url = export_url.replace('__FISCAL_YEAR__', yearSelected).replace('__UNIT_ID__', unitSelected);
            $('#export_excel').attr('href', export_url);

            dataTable.draw();
        });

        $('#executing_unit').on('change', () => {
            let yearSelected = parseInt($("#years").val());
            let unitSelected = parseInt($("#executing_unit").val());

            let export_url = '<?php echo e(route('export_xls.poa_tracking_physical_and_budget.reports', ['fiscalYearId' => '__FISCAL_YEAR__', 'executingUnitId' => '__UNIT_ID__']), false); ?>';
            export_url = export_url.replace('__FISCAL_YEAR__', yearSelected).replace('__UNIT_ID__', unitSelected);
            $('#export_excel').attr('href', export_url);

            dataTable.draw();
        });

        /**
         * Ajusta tamaño de headers y footers de la tabla cuando se redimensiona la pantalla
         */
        $(window).resize(() => {
            $('#poa_tb').DataTable().columns.adjust()
            $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
        })

    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/reports/tracking/poa_physical_budget/poa_physical_budget.blade.php ENDPATH**/ ?>