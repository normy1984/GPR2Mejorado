<?php if (Auth::check() && Auth::user()->can('budget.progress.project_tracking.execution')): ?>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div style="text-align: center; margin-bottom: 17px">
                  <span id="chart" class="chart" data-percent="">
                      <span class="percent"></span>
                  </span>
                </div>
                <h3 class="text-center"><?php echo e(trans('budget_project_tracking.labels.budget_execution'), false); ?></h3>
                <div class="divider"></div>
                <p class="text-center"><?php echo e(trans('budget_project_tracking.labels.encoded_accrued'), false); ?></p>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item text-center">
                        <h4 class="list-group-item-heading"><?php echo e(trans('budget_project_tracking.labels.encoded'), false); ?></h4>
                        <p class="list-group-item-text" style="font-size: 20px"><span id="encoded_budget"></span></p>
                    </li>
                    <li class="list-group-item text-center">
                        <h4 class="list-group-item-heading"><?php echo e(trans('budget_project_tracking.labels.accrued'), false); ?></h4>
                        <p class="list-group-item-text green" style="font-size: 20px" id="accrued_budget"></p>
                    </li>
                    <li class="list-group-item text-center">
                        <h4 class="list-group-item-heading"><?php echo e(trans('budget_project_tracking.labels.difference'), false); ?></h4>
                        <p class="list-group-item-text orange" style="font-size: 20px" id="difference_budget"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <canvas id="myChart" style="max-height: 250px;"></canvas>
    </div>
</div>

<div class="row">
    <span class="fs-l"><?php echo e(trans('budget_project_tracking.labels.budget_execution_up'), false); ?></span> <span class="fw-b fs-l"><?php echo e($currentMonth, false); ?> - <?php echo e(now()->year, false); ?></span>
    <?php if (Auth::check() && Auth::user()->can('export.budget.progress.project_tracking.execution')): ?>
    <button id="export_excel" class="btn pull-right pdf-export-button">
        <i class="fa fa-file-excel-o"></i>
        <?php echo e(trans('reports.export.excel'), false); ?>

    </button>
    <?php endif; ?>
</div>

<div class="row">
    <table class="table report-table" id="tracking_project_tb">
        <thead>
        <tr>
            <th rowspan="2"></th>
            <th rowspan="2"><?php echo e(trans('budget_project_tracking.labels.activity_component'), false); ?></th>
            <th rowspan="2"><?php echo e(trans('budget_project_tracking.labels.activity_component'), false); ?></th>
            <th rowspan="2"><?php echo e(trans('budget_project_tracking.labels.encoded'), false); ?></th>
            <th rowspan="2"><?php echo e(trans('budget_project_tracking.labels.accrued'), false); ?></th>
            <th rowspan="2"><?php echo e(trans('budget_project_tracking.labels.budget_execution'), false); ?></th>
            <th colspan="12"><?php echo e(trans('budget_project_tracking.labels.accrued'), false); ?></th>
        </tr>
        <tr>
            <th><?php echo e(trans('budget_project_tracking.labels.jan'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.feb'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.mar'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.apr'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.may'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.jun'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.jul'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.aug'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.sep'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.oct'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.nov'), false); ?></th>
            <th><?php echo e(trans('budget_project_tracking.labels.dec'), false); ?></th>
        </tr>
        </thead>
    </table>
</div>

<script>
    $(() => {
        $('#export_excel').on('click', (e) => {
            e.preventDefault();
/*        console.log('Botón de exportación clicado. Iniciando solicitud AJAX para exportar Excel...');

            $.ajax({
                url: '<?php echo e(route('export.budget.progress.project_tracking.execution', ['id' => $projectId]), false); ?>',
                method: 'GET',
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
                    a.download = '<?php echo e(trans('budget_project_tracking.labels.file_name'), false); ?>';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            }).always(() => {
                hideLoading();
            }).fail(function() {
                hideLoading();
            });*/
    document.getElementById('export_excel').addEventListener('click', function (e) {
    e.preventDefault();
    showLoading();

    fetch('<?php echo e(route('export.budget.progress.project_tracking.execution', ['id' => $projectId]), false); ?>')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al descargar el archivo');
            }
            return response.blob();  // ✅ Convierte a Blob correctamente
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '<?php echo e(trans('budget_project_tracking.labels.file_name'), false); ?>';
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            hideLoading();
        });
});
        });
        let table = build_datatable($('#tracking_project_tb'), {
            dom: 't',
            paginate: false,
            ajax: {
                url: '<?php echo route('data.budget.progress.project_tracking.execution', ['id' => $projectId]); ?>',
                "dataSrc": (response) => {
                    if (response.exception !== '') {
                        notify(response.exception, 'warning')
                    }
                    return response.data;
                }
            },
            scrollX: true,
            responsive: false,
            scrollCollapse: true,
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false},
                {data: 'activity', visible: false, sortable: false, searchable: false},
                {data: 'budget_item', width: '20%', sortable: false, searchable: false},
                {data: 'encoded', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'accrued_aggregated', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'budget_execution', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jan_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'feb_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'mar_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'apr_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'may_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jun_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'jul_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'aug_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'sep_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'oct_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'nov_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'dec_accrued', width: '2%', sortable: false, searchable: false, class: 'text-center'}
            ],
            rowGroup: {
                startRender: (rows, group) => {
                    let numericVal = (i) => {

                        if (typeof i === 'string') {
                            i = i.replace(/[\£,]/g, '') * 1;
                        }
                        // check if number is valid.
                        if (Number.isNaN(i)) {
                            return 0;
                        }
                        return i;
                    };

                    let tr = $('<tr/>').append('<td>' + group + '</td>');
                    let encoded = 0.0;

                    // calculate activity(group) subtotals for all numeric columns
                    for (let i = 3; i < 18; i++) {
                        let subTotal = rows
                            .data()
                            .pluck(table.settings()[0].aoColumns[i].data)
                            .reduce((a, b) => {
                                return parseFloat(numericVal(a)) + parseFloat(numericVal(b));
                            }, 0);
                        tr.append('<td class="text-center">' + subTotal.toFixed(2) + '</td>');

                        // store subtotal for "encoded" columns
                        if (i === 3) {
                            encoded = subTotal;
                        }
                        // for column "accrued_aggregated" calculate percentage of executing budget and append cell to current row group
                        if (i === 4) {
                            tr.append('<td class="text-center">' + ((encoded > 0) ? (subTotal * 100 / encoded).toFixed(2) : (0).toFixed(2)) + '</td>');
                            i++;
                        }
                    }

                    return tr;
                },
                dataSrc: 'activity'
            },
            footerCallback: function () {
                let api = this.api(), json = api.ajax.json();

                let encoded_budget = json.totals ? json.totals.encoded : 0;
                let accrued_budget = json.totals ? json.totals.accrued : 0;
                let difference_budget = encoded_budget - accrued_budget;

                $('#encoded_budget').text(encoded_budget).number(true, 2).text('$ ' + $('#encoded_budget').text());
                $('#accrued_budget').text(accrued_budget).number(true, 2).text('$ ' + $('#accrued_budget').text());
                $('#difference_budget').text(difference_budget).number(true, 2).text('$ ' + $('#difference_budget').text());

                chart.update(((encoded_budget > 0) ? (accrued_budget * 100 / encoded_budget).toFixed(2) : 0.00));

                data.data.datasets[0].data = json.totals ? json.totals.months.accrued : [];
                new Chart(ctx, data);

            },
            initComplete: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            },
            drawCallback: () => {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
                $('.dataTables_scrollBody tfoot tr').css({visibility: 'collapse'});
            }
        });

        $('#chart').easyPieChart({
            easing: "easeOutElastic",
            delay: 3e3,
            barColor: "#26B99A",
            trackColor: "#fff",
            scaleColor: !1,
            lineWidth: 20,
            trackWidth: 16,
            lineCap: "butt",
            onStep: function (a, b, c) { // No ES6
                $(this.el).find(".percent").text(c.toFixed(2))
            }
        });

        let chart = $('#chart').data('easyPieChart');

        let data = {
            type: 'bar',
            data: {
                labels: ['<?php echo e(trans('budget_project_tracking.labels.jan'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.feb'), false); ?>',
                    '<?php echo e(trans('budget_project_tracking.labels.mar'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.apr'), false); ?>',
                    '<?php echo e(trans('budget_project_tracking.labels.may'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.jun'), false); ?>',
                    '<?php echo e(trans('budget_project_tracking.labels.jul'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.aug'), false); ?>',
                    '<?php echo e(trans('budget_project_tracking.labels.sep'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.oct'), false); ?>',
                    '<?php echo e(trans('budget_project_tracking.labels.nov'), false); ?>', '<?php echo e(trans('budget_project_tracking.labels.dec'), false); ?>'],
                datasets: [{
                    label: '<?php echo e(trans('budget_project_tracking.labels.accrued'), false); ?>',
                    data: [],
                    backgroundColor: '#03586A'
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 0
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.9,
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        };
        let ctx = document.getElementById("myChart").getContext('2d');

       
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?><?php /**PATH /var/www/html/resources/views/business/tracking/projects/budget/index.blade.php ENDPATH**/ ?>