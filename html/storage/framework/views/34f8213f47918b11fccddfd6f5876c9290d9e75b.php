<?php if (Auth::check() && Auth::user()->can('index.reports')): ?>
<?php $Plan = app('\App\Models\Business\Plan'); ?>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo e(trans('app.labels.reports'), false); ?></h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <i class="fa fa-list-alt"></i> <?php echo e(trans('reports.labels.reports_list'), false); ?>

                </h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="dashboard-title title_left col-sm-12 col-xs-12">
                            <h3>
                                <a class="template-accordion" data-toggle="collapse" href="#planning">
                                    <i class="fa fa-plus pl-2 pr-2"></i>
                                    <i class="fa fa-minus hidden pl-2 pr-2"></i></a>
                                <?php echo e(trans('reports.labels.planning'), false); ?>

                            </h3>
                        </div>
                        <div class="x_content mb-4 collapse" id="planning">
                            <?php if (Auth::check() && Auth::user()->can('index.ppi.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.ppi.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reportPpi'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('annual_budget_planning.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('annual_budget_planning.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.annual_budget_planning'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.pndandpdot.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.pndandpdot.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reportPDOTandPND'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.psandpnd.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.psandpnd.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reportPNDandPS'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.pdotandpei.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.pdotandpei.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reportPEIandPDOT'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.pac.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('view.index.pac.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.pac.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('lotaip.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('lotaip.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.lotaip.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('pei_structure_report.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('pei_structure_report.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.pei_structure.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('sectorial_plans_matrix.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('sectorial_plans_matrix.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.sectorial_plans.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('agreement_for_results.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('agreement_for_results.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.agreement_for_results.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.executive_summary.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.executive_summary.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reports_executive_summary'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('projects_repository.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('projects_repository.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.reports_projects_repository'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('incomes_expenses.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('incomes_expenses.reports'), false); ?>"
                                       class="ajaxify">
                                        <?php echo e(trans('reports.income_expense.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="dashboard-title title_left col-sm-12 col-xs-12">
                            <h3>
                                <a class="template-accordion" data-toggle="collapse" href="#budget">
                                    <i class="fa fa-plus pl-2 pr-2"></i>
                                    <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                </a>
                                <?php echo e(trans('reports.labels.budget'), false); ?>

                            </h3>
                        </div>
                        <div class="x_content mb-4 collapse" id="budget">
                            <?php if (Auth::check() && Auth::user()->can('index.poa.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('view.index.poa.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.poa.title_planning'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('budget_adjustment.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('budget_adjustment.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.budget_adjustment.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('index.projects_activities.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('index.projects_activities.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.project_activities_poa.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="dashboard-title title_left col-sm-12 col-xs-12">
                            <h3>
                                <a class="template-accordion" data-toggle="collapse" href="#execution">
                                    <i class="fa fa-plus pl-2 pr-2"></i>
                                    <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                </a>
                                <?php echo e(trans('reports.labels.execution'), false); ?>

                            </h3>
                        </div>
                        <div class="x_content mb-4 collapse" id="execution">
                            <?php if (Auth::check() && Auth::user()->can('physical_advance.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('physical_advance.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.physical_advance.title'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                            <?php if (Auth::check() && Auth::user()->can('activities_quarterly_execution.reports')): ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                <h2>
                                    <a href="<?php echo e(route('activities_quarterly_execution.reports'), false); ?>" class="ajaxify">
                                        <?php echo e(trans('reports.labels.activities_quarterly_execution'), false); ?>

                                    </a>
                                </h2>
                                <div class="ln_solid mb-0 mt-0"></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="dashboard-title title_left col-sm-12 col-xs-12">
                            <h3>
                                <a class="template-accordion" data-toggle="collapse" href="#tracing">
                                    <i class="fa fa-plus pl-2 pr-2"></i>
                                    <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                </a>
                                <?php echo e(trans('reports.labels.tracing'), false); ?>

                            </h3>
                        </div>
                        <div class="x_content mb-4 collapse" id="tracing">

                            <div class="dashboard-title title_left col-sm-12 col-xs-12">
                                <h3>
                                    <a class="template-accordion" data-toggle="collapse" href="#tracing_1">
                                        <i class="fa fa-plus pl-2 pr-2"></i>
                                        <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                    </a>
                                    Planificación
                                </h3>
                            </div>
                            <div class="x_content mb-4 collapse" id="tracing_1">
                                <?php if (Auth::check() && Auth::user()->can('index.indicators.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="#" id="indicator_export_excel">
                                            <?php echo e(trans('reports.indicators.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('poa_tracking_physical_and_budget.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('poa_tracking_physical_and_budget.reports'), false); ?>"
                                           class="ajaxify">
                                            <?php echo e(trans('reports.labels.poaPhysicalBudget'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.planning_execution_projects.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a role="button" href="<?php echo e(route('index.planning_execution_projects.reports'), false); ?>"
                                           class="ajaxify">
                                            <?php echo e(trans('reports.labels.planning_execution_projects'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.executive_progress_unit.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.executive_progress_unit.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.executive_progress_unit.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.progress_investment_project.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.progress_investment_project.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.progress_investment_project.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.executive_progress_project.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.executive_progress_project.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.executive_progress_project.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.progress_investment_projects_executed_programmed2.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.progress_investment_projects_executed_programmed2.reports'), false); ?>"
                                           class="ajaxify">
                                            <?php echo e(trans('reports.progress_investment_projects_executed_programmed.title_by_date'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.progress_investment_projects_executed_programmed.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.progress_investment_projects_executed_programmed.reports'), false); ?>"
                                           class="ajaxify">
                                            <?php echo e(trans('reports.progress_investment_projects_executed_programmed.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.admin_activities_budget.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.admin_activities_budget.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.admin_activities_budget.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.admin_activities.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.admin_activities.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.admin_activities.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.admin_activities_responsible_unit.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.admin_activities_responsible_unit.reports'), false); ?>"
                                           class="ajaxify">
                                            <?php echo e(trans('reports.admin_activities_responsible_unit.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.project_admin_activities.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.project_admin_activities.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.project_admin_activities.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.execution_projects.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.execution_projects.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.labels.execution_projects'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.reforms_and_certifications.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.reforms_and_certifications.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.reforms_and_certifications.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.risk_mitigation_plan.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.risk_mitigation_plan.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.risk_mitigation_plan.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('index.task_milestone.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.task_milestone.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.task_milestone.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('ongoing_projects.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('ongoing_projects.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.ongoing_projects.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="dashboard-title title_left col-sm-12 col-xs-12">
                                <h3>
                                    <a class="template-accordion" data-toggle="collapse" href="#tracing_2">
                                        <i class="fa fa-plus pl-2 pr-2"></i>
                                        <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                    </a>
                                    Presupuesto
                                </h3>
                            </div>
                            <div class="x_content mb-4 collapse" id="tracing_2">
                                <?php if(api_available()): ?>
                                    <?php if (Auth::check() && Auth::user()->can('index.poa_tracking.reports')): ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <h2>
                                            <a href="<?php echo e(route('index.poa_tracking.reports'), false); ?>" class="ajaxify">
                                                <?php echo e(trans('reports.poa.title_tracking'), false); ?>

                                            </a>
                                            <?php
    \Illuminate\Support\Facades\Log::info('Se mostró el bloque de seguimiento');
?>
                                        </h2>
                                        <div class="ln_solid mb-0 mt-0"></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (Auth::check() && Auth::user()->can('index.planning_accrued.reports')): ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <h2>
                                            <a href="<?php echo e(route('index.planning_accrued.reports'), false); ?>" class="ajaxify">
                                                <?php echo e(trans('reports.planning_accrued.title'), false); ?>

                                            </a>
                                        </h2>
                                        <div class="ln_solid mb-0 mt-0"></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (Auth::check() && Auth::user()->can('index.participatory_budget.reports')): ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <h2>
                                            <a href="<?php echo e(route('index.participatory_budget.reports'), false); ?>" class="ajaxify">
                                                <?php echo e(trans('reports.participatory_budget.title'), false); ?>

                                            </a>
                                        </h2>
                                        <div class="ln_solid mb-0 mt-0"></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (Auth::check() && Auth::user()->can('budget_card.reports')): ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <h2>
                                            <a href="<?php echo e(route('budget_card.reports'), false); ?>" class="ajaxify">
                                                <?php echo e(trans('reports.labels.budget_card'), false); ?>

                                            </a>
                                        </h2>
                                        <div class="ln_solid mb-0 mt-0"></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (Auth::check() && Auth::user()->can('index.budget_card_expenses.reports')): ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <h2>
                                            <a href="<?php echo e(route('index.budget_card_expenses.reports'), false); ?>" class="ajaxify">
                                                <?php echo e(trans('reports.budget_card_expenses.title'), false); ?>

                                            </a>
                                        </h2>
                                        <div class="ln_solid mb-0 mt-0"></div>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (Auth::check() && Auth::user()->can('incomes_expenses_execution.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('incomes_expenses_execution.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.income_expense.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="dashboard-title title_left col-sm-12 col-xs-12">
                                <h3>
                                    <a class="template-accordion" data-toggle="collapse" href="#tracing_3">
                                        <i class="fa fa-plus pl-2 pr-2"></i>
                                        <i class="fa fa-minus hidden pl-2 pr-2"></i>
                                    </a>
                                    PAC
                                </h3>
                            </div>
                            <div class="x_content mb-4 collapse" id="tracing_3">
                                <?php if (Auth::check() && Auth::user()->can('index.pac_tracking.reports')): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <h2>
                                        <a href="<?php echo e(route('index.pac_tracking.reports'), false); ?>" class="ajaxify">
                                            <?php echo e(trans('reports.pac.title'), false); ?>

                                        </a>
                                    </h2>
                                    <div class="ln_solid mb-0 mt-0"></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.template-accordion').on('click', (e) => {
        $(e.currentTarget).find('i').each((index, element) => {
            $(element).hasClass('hidden') ? $(element).removeClass('hidden') : $(element).addClass('hidden')
        })
    });

    $('#indicator_export_excel').on('click', (e) => {
        e.preventDefault();

        $.ajax({
            url: '<?php echo e(route('index.indicators.reports'), false); ?>',
            method: 'GET',
            beforeSend: () => {
             
                showLoading();
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: (response) => {
                let a = document.createElement('a');
                let url = window.URL.createObjectURL(response);
                a.href = url;
                a.download = '<?php echo e(trans('reports.indicators.title'), false); ?>';
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            }
        }).always(() => {
            hideLoading();
        });
    });

</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/reports/index.blade.php ENDPATH**/ ?>