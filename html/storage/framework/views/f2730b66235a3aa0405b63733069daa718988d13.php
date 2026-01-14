

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/font-awesome/css/font-awesome.css.map'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/font-awesome/css/font-awesome.css.map'), false); ?>" rel="stylesheet"/>


    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/nprogress/nprogress.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.nonblock.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.buttons.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/switchery/dist/switchery.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/iCheck/skins/flat/green.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/select2/dist/css/select2.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.skinModern.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/fullcalendar/dist/fullcalendar.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/vendors/jQuery-Smart-Wizard/styles/smart_wizard.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/gentelella/vendors/dropzone/dist/min/dropzone.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/jsoneditor/jsoneditor.min.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/timepicker/jquery.timepicker.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('vendor/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'), false); ?>" rel="stylesheet"/>

    <!-- SlickGrid -->
    <link href="<?php echo e(mix('vendor/slickgrid/slick.grid.css'), false); ?>" rel="stylesheet"/>

    <!-- jsgantt improved -->
    <link href="<?php echo e(mix('vendor/jsgantt-improved/dist/jsgantt.css'), false); ?>" rel="stylesheet"/>

    <!-- Quill Editor -->
    <link href="<?php echo e(mix('vendor/quill/quill.snow.css'), false); ?>" rel="stylesheet"/>

    <link href="<?php echo e(mix('vendor/gentelella/css/custom.min.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('css/app.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('css/theme.css'), false); ?>" rel="stylesheet"/>
    <link href="<?php echo e(mix('css/dashboard.css'), false); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('body_classes'); ?> nav-md <?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <div class="container body">
        <!-- Main container -->
        <div class="main_container" id="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <?php echo $__env->make('layout.left_col', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="top_nav">
                <?php echo $__env->make('layout.top_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="right_col" role="main" id="main_content">
                <!-- Load by AJAX -->
            </div>


        </div>

        <!-- Loading spinner -->
        <div id="loading-spinner">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="padding-top: 10px;">
                    <i class="fa fa-spinner fa-spin" style="font-size: 5em;"></i>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Logout form -->
        <form action="<?php echo e(route('logout'), false); ?>" method="POST" id="logout-form" style="display: none;" autocomplete="off">
            <?php echo csrf_field(); ?>
        </form>

        <!-- Util extra large modal -->
        <div id="util-modal-xl" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <!-- Load modal content by AJAX -->
            </div>
        </div>

        <!-- Util large modal -->
        <div id="util-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg <?php if(!session('changedPassword')): ?> no-passwd <?php endif; ?>">
                <!-- Load modal content by AJAX -->
            </div>
        </div>

        <!-- Util small modal -->
        <div id="util-modal-sm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <!-- Load modal content by AJAX -->
            </div>
        </div>

        <!-- Util standard modal -->
        <div id="util-modal-st" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <!-- Load modal content by AJAX -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery/dist/jquery.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery/dist/jquery.min.map'), false); ?>" type="application/json"></script>
    <script src="<?php echo e(mix('vendor/jquery-form/jquery.form.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-form/jquery.form.min.js.map'), false); ?>" type="application/json"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/jquery.validate.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/localization/messages_es.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-validation/additional-methods.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jquery-number/jquery.number.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/moment/min/moment-with-locales.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery-mousewheel/jquery.mousewheel.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/nprogress/nprogress.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/fastclick/lib/fastclick.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.nonblock.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/pnotify/dist/pnotify.buttons.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/switchery/dist/switchery.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/iCheck/icheck.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/select2/dist/js/select2.full.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/select2/dist/js/i18n/es.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/datatables.net-rowgroup/dataTables.rowGroup.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/datatables-rowsgroup-2.0.0/dataTables.rowsGroup.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jszip/dist/jszip.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/datatables.net-buttons/dataTables.buttons.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/datatables.net-buttons/buttons.html5.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/timepicker/jquery.timepicker.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/fullcalendar/dist/fullcalendar.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/fullcalendar/dist/locale/es.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/chart.js/dist/Chart.bundle.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/gauge.js/dist/gauge.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/echarts/dist/echarts.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/gentelella/vendors/dropzone/dist/min/dropzone.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/jsoneditor/jsoneditor.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jsoneditor/jsoneditor.js.map'), false); ?>" type="application/json"></script>

    <script src="<?php echo e(mix('vendor/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/knockout/knockout-latest.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/knockout.validation/knockout.validation.js'), false); ?>"></script>

    <!-- PDF export -->
    <script src="<?php echo e(mix('vendor/jspdf/jspdf.min.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/jspdf-autotable/jspdf.plugin.autotable.min.js'), false); ?>"></script>

    <script src="<?php echo e(mix('vendor/bootbox/bootbox.js'), false); ?>"></script>

    <!-- SlickGrid -->
    <script src="<?php echo e(mix('vendor/slickgrid/lib/jquery.event.drag-2.3.0.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/slickgrid/slick.core.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/slickgrid/slick.grid.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/slickgrid/slick.formatters.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/slickgrid/slick.editors.js'), false); ?>"></script>
    <script src="<?php echo e(mix('vendor/slickgrid/slick.dataview.js'), false); ?>"></script>

    <!-- jsgantt improved -->
    <script src="<?php echo e(mix('vendor/jsgantt-improved/dist/jsgantt.js'), false); ?>"></script>

    <!-- Quill Editor -->
    <script src="<?php echo e(mix('vendor/quill/quill.js'), false); ?>"></script>

    <!-- amcharts -->
    <script src="//www.amcharts.com/lib/4/core.js"></script>
    <script src="//www.amcharts.com/lib/4/charts.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="<?php echo e(mix('js/main.js'), false); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/layout/index.blade.php ENDPATH**/ ?>