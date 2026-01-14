<?php if (Auth::check() && Auth::user()->can('index.poa_tracking.reports')): ?>

<div>
    <div class="page-title">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-11 col-sm-11 col-xs-11">
                <h3><?php echo e(trans('app.labels.reports'), false); ?></h3>
                <h2>
                    <i class="fa fa-list-alt"></i> <?php echo e(trans('reports.poa.title_tracking'), false); ?>

                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-12 mb-0">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <h6><?php echo e(trans('reforms.labels.executing_unit'), false); ?></h6>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control select2" id="executing_unit">
                                    <option value="0"><?php echo e(html_entity_decode(trans("app.placeholders.select")), false); ?></option>
                                    <?php $__currentLoopData = $executingUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($unit->id, false); ?>">
                                            <?php echo e($unit->code, false); ?> - <?php echo e($unit->name, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 mb-0">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <h6><?php echo e(trans('reforms.labels.project'), false); ?></h6>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control select2" id="project" disabled>
                                    <option value="0"><?php echo e(html_entity_decode(trans("app.placeholders.select")), false); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="text-right pull-right mt-3">
                                <?php if (Auth::check() && Auth::user()->can('export.index.poa_tracking.reports')): ?>
                                <a id="export_pdf" class="btn pdf-export-button">
                                    <i class="fa fa-file-pdf-o"></i><?php echo e(trans('reports.export.excel'), false); ?>

                                </a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>

                    <table class="table report-table" id="poa_tb">
                        <thead>
                        <tr>
                            <th colspan="7"><?php echo e(trans('reports.poa.programmatic_structure'), false); ?></th>
                            <th colspan="5"><?php echo e(trans('reports.poa.alignment_budget_item'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.competence'), false); ?></th>
                            <th colspan="4"><?php echo e(trans('reports.poa.alignment_orientation'), false); ?></th>
                            <th colspan="3"><?php echo e(trans('reports.poa.alignment_location'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.source'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.institution'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.budget_item'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.assigned'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.encoded'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.for_compromising'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.total_accrued'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.jan'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.feb'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.mar'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.t1'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.apr'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.may'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.jun'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.t2'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.jul'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.aug'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.sep'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.t3'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.oct'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.nov'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.dec'), false); ?></th>
                            <th rowspan="2"><?php echo e(trans('reports.poa.t4'), false); ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><?php echo e(trans('reports.poa.area'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.program'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.subprogram'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.project'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.executing_unit'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.activity'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.nature'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.group'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.subgroup'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.item'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.description'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.orientation'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.direction'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.category'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.sub_category'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.province'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.canton'), false); ?></th>
                            <th><?php echo e(trans('reports.poa.parish'), false); ?></th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr id="tfoot-tr-4">
                            <th class="text-right" colspan="23"><?php echo e(trans('app.labels.footer_total'), false); ?></th>
                            <th class="text-center" id="tfoot-th-total-assigned"></th>
                            <th class="text-center" id="tfoot-th-total-encoded"></th>
                            <th class="text-center" id="tfoot-th-total-for-compromising"></th>
                            <th class="text-center" id="tfoot-th-total"></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                            <th colspan=""></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <a id="cancelLinks" href="<?php echo e(route('index.reports'), false); ?>"
               class="btn btn-info ajaxify"><?php echo e(trans('app.labels.backward'), false); ?>

            </a>
        </div>
    </div>

</div>

<script>
    $(() => {

        let dataTable = build_datatable($('#poa_tb'), {
            dom: 't',
            ajax: {
                url: '<?php echo route('data.index.poa_tracking.reports'); ?>',
                type: 'post',
                dataSrc: function (response) {
                    if (response.exception !== '') {
                        notify(response.exception, 'warning')
                    }
                    return response.data;
                },
                "data": (d) => {
                    const data= $.extend({}, d, {
                        "filters": {
           
                            executing_unit: $("#executing_unit").val(),
                            project: $('#project').val(),
                        },
                        _token: '<?php echo e(csrf_token(), false); ?>'
                    });
                     console.log("🔍 Datos enviados al servidor:", data); 
                     return data;
                }
            },
            paging: false,
            responsive: false,
            scrollX: true,
            scrollY: '400px',
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false},
                {data: 'area', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'program', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'subprogram', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'project', width: '5%', sortable: false, searchable: true, class: 'text-center'},
                {data: 'executingUnit', width: '5%', sortable: false, searchable: true, class: 'text-center'},
                {data: 'activity', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'nature', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'group', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'subgroup', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'item', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'description', width: '5%', sortable: false, searchable: false},
                {data: 'competence', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'orientation', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'direction', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'category', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'subCategory', width: '5%', sortable: false, searchable: false},
                {data: 'province', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'canton', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'parish', width: '5%', sortable: false, searchable: false},
                {data: 'source', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'institution', width: '5%', sortable: false, searchable: false},
                {data: 'code', width: '10%', sortable: false, searchable: false},
                {data: 'assigned', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'encoded', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'for_compromising', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'total_amount', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jan', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'feb', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'mar', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 't1', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'apr', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'may', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jun', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 't2', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jul', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'aug', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'sep', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 't3', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'oct', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'nov', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'dec', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 't4', width: '10%', sortable: false, searchable: false, class: 'text-center'}
            ],
            initComplete: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            drawCallback: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            footerCallback: function () {
                let api = this.api(), json = api.ajax.json();

                // Update footer
                $('#tfoot-tr-4 #tfoot-th-total').html(
                    '$' + (json.totalAmount !== undefined ? json.totalAmount : 0.00)
                );

                $('#tfoot-tr-4 #tfoot-th-total-encoded').html(
                    '$' + (json.totalEncoded !== undefined ? json.totalEncoded : 0.00)
                );

                $('#tfoot-tr-4 #tfoot-th-total-assigned').html(
                    '$' + (json.totalAssigned !== undefined ? json.totalAssigned : 0.00)
                );

                $('#tfoot-tr-4 #tfoot-th-total-for-compromising').html(
                    '$' + (json.totalForCompromising !== undefined ? json.totalForCompromising : 0.00)
                );
            }
        });

        // Initialize clear selection buttons
        $('.input-group').each((index, element) => {
            let criterionSelect = $(element).find('select');
            let criterionClearButton = $(element).find('span.input-group-addon');

            criterionClearButton.on('click', () => {
                criterionSelect.val(null).trigger('change')
            })
        });

        $('.select2').select2({
            placeholder: "<?php echo e(html_entity_decode(trans('app.placeholders.select')), false); ?>"
        }).on('change', (e) => {

            if ($(e.currentTarget).attr('id') === 'executing_unit') {
                $('#project').html('');
                $('#project').prop("disabled", true);
                $('#project').append('<option value="0"><?php echo e(html_entity_decode(trans("app.placeholders.select")), false); ?></option>');

                if ($('#executing_unit').val() !== '0') {// '0' default option

                    let url = '<?php echo e(route('projects.poa.reports', ['executingUnitId' => '__ID__']), false); ?>';
                    url = url.replace('__ID__', $('#executing_unit').val());
 console.log("🔍 URL de la consulta:", url); 
                    pushRequest(url, null, (response) => {
                        let opt = [];
                        $.each(response, (index, value) => {
                            opt.push({
                                id: value.id,
                                text: value.project.full_cup + ' - ' + value.project.name,
                            });
                        });
                        $('#project').select2({
                            data: opt
                        });
                        if (response.length > 0) {
                            $('#project').prop("disabled", false);
                        }
                    }, 'get', null, false);
                }
            }
            dataTable.draw();
        });

        $('#export_pdf').on('click', (e) => {
            
            e.preventDefault();

            $.ajax({
                
                url: '<?php echo e(route('export.index.poa_tracking.reports'), false); ?>',
                method: 'GET',
                data: {
                    filters: {
                        executing_unit: $("#executing_unit").val(),
                        project: $('#project').val()
                    }
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: () => {
                     
                    showLoading();
                },
                success: (response) => {
                    let a = document.createElement('a');
                    let url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = '<?php echo e(trans('reports.poa.export_xls'), false); ?>';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            }).always(() => {
                hideLoading();
            }).fail(function () {
                hideLoading();
            });
        });
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/reports/tracking/poa/index.blade.php ENDPATH**/ ?>