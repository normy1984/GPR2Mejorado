<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ThresholdController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Business\Catalogs\BudgetClassifierController;
use App\Http\Controllers\Business\Catalogs\CPCController;
use App\Http\Controllers\Business\Catalogs\FinancingSourceController;
use App\Http\Controllers\Business\Catalogs\GeographicLocationController;
use App\Http\Controllers\Business\Catalogs\MeasureUnitController;
use App\Http\Controllers\Business\Catalogs\SpendingGuideController;
use App\Http\Controllers\Business\Execution\AdminActivityController;
use App\Http\Controllers\Business\Execution\CertificationController;
use App\Http\Controllers\Business\Execution\IndicatorProgressController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\ActivityProjectFiscalYearController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\BudgetItemController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\CurrentExpenditureElementController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\IncomeController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\ProjectController;
use App\Http\Controllers\Business\Execution\ProgrammaticStructure\PublicPurchaseController;
use App\Http\Controllers\Business\Execution\ProjectReprogrammingController;
use App\Http\Controllers\Business\Execution\Reform\ReformController;
use App\Http\Controllers\Business\Execution\ReprogrammingController;
use App\Http\Controllers\Business\Planning\AttachmentsController;

use App\Http\Controllers\Business\Planning\BudgetAdjustmentController;
use App\Http\Controllers\Business\Planning\LinkController;
use App\Http\Controllers\Business\Planning\LogicalFrameController;
use App\Http\Controllers\Business\Planning\PlanController;
use App\Http\Controllers\Business\Planning\PlanIndicatorController;
use App\Http\Controllers\Business\Planning\PrioritizationTemplateController;
use App\Http\Controllers\Business\Planning\ProjectFiscalYearController;
use App\Http\Controllers\Business\Planning\ProjectsRepositoryController;
use App\Http\Controllers\Business\Reports\ExecutionReportsController;
use App\Http\Controllers\Business\Reports\PlanningReportsController;
use App\Http\Controllers\Business\Reports\TrackingReportsController;
use App\Http\Controllers\Business\StaffMeetings\StaffMeetingsController;
use App\Http\Controllers\Business\Tracking\BudgetProjectTrackingController;
use App\Http\Controllers\Business\Tracking\ProjectPhysicalTrackingController;
use App\Http\Controllers\Business\Tracking\ProjectTrackingController;
use App\Http\Controllers\Business\Tracking\ResultsController;
use App\Http\Controllers\Business\UserTasks\UserTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\System\FileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Auth::routes();
});

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/unauthorized', [AppController::class, 'unauthorized'])->name('unauthorized.app');
    Route::get('/index/{module?}', [AppController::class, 'index'])->name('index.app');
    Route::get('/', [AppController::class, 'indexModules'])->name('index_modules.app');

    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard.app');

    Route::get('/confirmed_email', [AppController::class, 'confirmedEmail'])->name('confirmed_email');


    Route::group(['prefix' => 'tasks'], function () {

        Route::get('/', [UserTaskController::class, 'index'])->name('index.tasks');
        Route::post('/', [UserTaskController::class, 'store'])->name('store.tasks');
        Route::put('/{task}', [UserTaskController::class, 'update'])->name('update.tasks');
        Route::delete('/{task}', [UserTaskController::class, 'delete'])->name('delete.tasks');
        Route::get('/report', [UserTaskController::class, 'export'])->name('export.tasks');

    });

    Route::group(['prefix' => 'staff'], function () {

        Route::get('/', [StaffMeetingsController::class, 'index'])->name('index.staff');
        Route::get('/data', [StaffMeetingsController::class, 'data'])->name('data.index.staff');
        Route::post('/', [StaffMeetingsController::class, 'store'])->name('store.staff');
        Route::put('/{staffMeeting}', [StaffMeetingsController::class, 'update'])->name('update.staff');
        Route::get('/{staffMeeting}', [StaffMeetingsController::class, 'show'])->name('show.staff');

        Route::get('/search/activities', [StaffMeetingsController::class, 'searchActivity'])->name('search.activity.staff');
        Route::get('/project/activities/tasks', [StaffMeetingsController::class, 'searchTaskActivity'])->name('tasks.activity.staff');

        Route::get('/activity/{staffActivity}/edit', [StaffMeetingsController::class, 'editActivity'])->name('edit.activity.staff');
        Route::put('/activity/{staffActivity}', [StaffMeetingsController::class, 'updateActivity'])->name('update.activity.staff');
        Route::post('/activity', [StaffMeetingsController::class, 'storeActivity'])->name('store.activity.staff');
        Route::delete('/activity/{staffActivity}', [StaffMeetingsController::class, 'deleteActivity'])->name('delete.activity.staff');

        Route::get('/chart/{departmentId}', [StaffMeetingsController::class, 'chart'])->name('chart.staff');

    });

    /* Profile */
    Route::group(['prefix' => 'profile'], function () {

        Route::get('/', [ProfileController::class, 'index'])->name('index.profile');

        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit.profile');
        Route::put('/update', [ProfileController::class, 'update'])->name('update.edit.profile');
        Route::put('/check/email', [ProfileController::class, 'checkEmail'])->name('email.check.profile');

        Route::get('/password', [ProfileController::class, 'changePassword'])->name('change.password.profile');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('update.password.profile');

    });

    /* Admin */
    Route::group(['prefix' => 'admin', 'middleware' => ['route']], function () {

        // roles
        Route::get('/roles/checkname/create', [RoleController::class, 'checkNameExists'])->name('checkname.create.roles');
        Route::get('/roles/checkname/edit', [RoleController::class, 'checkNameExists'])->name('checkname.edit.roles');
        Route::get('/roles/data', [RoleController::class, 'data'])->name('data.index.roles');
        Route::put('/roles/status/{id}', [RoleController::class, 'status'])->name('status.roles');
        Route::get('/roles/permissions/{id}', [RoleController::class, 'permissions'])->name('permissions.roles');
        Route::put('/roles/permissions/one', [RoleController::class, 'onePermissions'])->name('one.permissions.roles');
        Route::put('/roles/permissions/all', [RoleController::class, 'allPermissions'])->name('all.permissions.roles');

        Route::resource('roles', RoleController::class, [
            'parameters' => ['roles' => 'id'],
            'names' => [
                'index' => 'index.roles',
                'create' => 'create.roles',
                'store' => 'store.create.roles',
                'show' => 'show.roles',
                'edit' => 'edit.roles',
                'update' => 'update.edit.roles',
                'destroy' => 'destroy.roles'
            ]
        ]);

        // users
        Route::get('/users/data', [UserController::class, 'data'])->name('data.index.users');
        Route::get('/users/checkusername/create', [UserController::class, 'checkUsernameExists'])->name('checkusername.create.users');
        Route::get('/users/checkusername/update', [UserController::class, 'checkUsernameExists'])->name('checkusername.edit.users');
        Route::delete('/users/bulk/destroy', [UserController::class, 'bulkDestroy'])->name('bulk.destroy.users');
        Route::put('/users/status/{id}', [UserController::class, 'status'])->name('status.users');
        Route::get('/users/password/{id}', [ProfileController::class, 'changePassword'])->name('password.users');
        Route::get('/users/password/update/{id}', [ProfileController::class, 'updatePassword'])->name('update.password.users');

        Route::resource('users', UserController::class, [
            'parameters' => ['users' => 'id'],
            'names' => [
                'index' => 'index.users',
                'create' => 'create.users',
                'store' => 'store.create.users',
                'show' => 'show.users',
                'edit' => 'edit.users',
                'update' => 'update.edit.users',
                'destroy' => 'destroy.users'
            ]
        ]);

        Route::get('/users/change_fiscal_year/show', [UserController::class, 'changeFiscalYear'])->name('change_fiscal_year.users');
        Route::post('/users/change_fiscal_year/update', [UserController::class, 'setFiscalYearOnUserSession'])->name('update.change_fiscal_year.users');

        // Departments
        Route::get('/departments/data', [DepartmentController::class, 'data'])->name('data.index.departments');
        Route::put('/departments/status/{id}', [DepartmentController::class, 'status'])->name('status.departments');

        Route::resource('departments', DepartmentController::class, [
            'parameters' => ['departments' => 'id'],
            'names' => [
                'index' => 'index.departments',
                'create' => 'create.departments',
                'store' => 'store.create.departments',
                'show' => 'show.departments',
                'edit' => 'edit.departments',
                'update' => 'update.edit.departments',
                'destroy' => 'destroy.departments'
            ]
        ]);

        // Files

        Route::get('/files/search_operational_goals_plans', [FileController::class, 'searchOperationalGoalsPlans'])->name('search_operational_goals_plans.index.files');

        Route::get('/files/data_plans', [FileController::class, 'dataPlans'])->name('data_plans.index.files');
        Route::get('/files/data_projects', [FileController::class, 'dataProjects'])->name('data_projects.index.files');
        Route::get('/files/data_tracking', [FileController::class, 'dataTracking'])->name('data_tracking.index.files');

        Route::get('/files/index_plans', [FileController::class, 'indexPlans'])->name('index_plans.index.files');
        Route::get('/files/index_projects', [FileController::class, 'indexProjects'])->name('index_projects.index.files');
        Route::get('/files/index_tracking', [FileController::class, 'indexTracking'])->name('index_tracking.index.files');

        Route::get('/files/download_justifications/{id}', [FileController::class, 'downloadJustifications'])->name('download_justifications.index.files');
        Route::get('/files/download_attachments/{id}', [AttachmentsController::class, 'download'])->name('download_attachments.index.files');
        Route::get('/files/download_indicators/{id}', [PlanIndicatorController::class, 'download'])->name('download_indicators.index.files');
        Route::get('/files/download_reforms/{id}', [FileController::class, 'downloadReforms'])->name('download_reforms.index.files');

        Route::resource('files', FileController::class, [
            'parameters' => ['files' => 'id'],
            'names' => [
                'index' => 'index.files'
            ]
        ]);
        Route::get('/reports/users/index', [ReportController::class, 'usersIndex'])->name('index.users.config_reports');
        Route::get('/reports/users/index/data', [ReportController::class, 'usersData'])->name('data.index.users.config_reports');

        Route::get('/reports/projects/index', [ReportController::class, 'projectIndex'])->name('index.projects.config_reports');
        Route::get('/reports/projects/index/data', [ReportController::class, 'projectData'])->name('data.index.projects.config_reports');

        Route::get('/reports/audit/index', [ReportController::class, 'auditIndex'])->name('index.audit.config_reports');
        Route::get('/reports/audit/index/data', [ReportController::class, 'auditData'])->name('data.index.audit.config_reports');
        Route::get('/reports/audit/index/export', [ReportController::class, 'auditExport'])->name('export.index.audit.config_reports');
        Route::get('/reports/audit/index/details/{id}', [ReportController::class, 'auditDetails'])->name('detail.index.audit.config_reports');

    });

    /* Catalogs */
    Route::group(['prefix' => 'catalogs', 'middleware' => ['route']], function () {

        // Geographic Locations
        Route::get('/geographic_locations/data', [GeographicLocationController::class, 'data'])->name('data.index.geographic_locations.module_configuration_catalogs');
        Route::get('/geographic_locations/create/type/{type}',
            [GeographicLocationController::class, 'loadByTypes'])->name('type.create.geographic_locations.module_configuration_catalogs');
        Route::put('/geographic_locations/status/{id}',
            [GeographicLocationController::class, 'status'])->name('status.geographic_locations.module_configuration_catalogs');

        Route::resource('geographic_locations', GeographicLocationController::class, [
            'parameters' => ['geographic_locations' => 'id'],
            'names' => [
                'index' => 'index.geographic_locations.module_configuration_catalogs',
                'create' => 'create.geographic_locations.module_configuration_catalogs',
                'store' => 'store.create.geographic_locations.module_configuration_catalogs',
                'show' => 'show.geographic_locations.module_configuration_catalogs',
                'edit' => 'edit.geographic_locations.module_configuration_catalogs',
                'update' => 'update.edit.geographic_locations.module_configuration_catalogs',
                'destroy' => 'destroy.geographic_locations.module_configuration_catalogs'
            ]
        ]);

        // Financing Sources
        Route::get('/financing_sources/data', [FinancingSourceController::class, 'data'])->name('data.index.financing_sources.module_configuration_catalogs');
        Route::put('/financing_sources/status/{id}', [FinancingSourceController::class, 'status'])->name('status.financing_sources.module_configuration_catalogs');

        Route::resource('financing_sources', FinancingSourceController::class, [
            'parameters' => [
                'financing_sources' => 'id',
            ],
            'names' => [
                'index' => 'index.financing_sources.module_configuration_catalogs',
                'create' => 'create.financing_sources.module_configuration_catalogs',
                'store' => 'store.create.financing_sources.module_configuration_catalogs',
                'edit' => 'edit.financing_sources.module_configuration_catalogs',
                'update' => 'update.edit.financing_sources.module_configuration_catalogs',
                'destroy' => 'destroy.financing_sources.module_configuration_catalogs'
            ]
        ]);

        // CPC
        Route::get('/cpc/data', [CPCController::class, 'data'])->name('data.index.cpc.module_configuration_catalogs');
        Route::put('/cpc/status/{id}', [CPCController::class, 'status'])->name('status.cpc.module_configuration_catalogs');

        Route::resource('cpc', CPCController::class, [
            'parameters' => ['cpc' => 'id'],
            'names' => [
                'index' => 'index.cpc.module_configuration_catalogs',
                'create' => 'create.cpc.module_configuration_catalogs',
                'store' => 'store.create.cpc.module_configuration_catalogs',
                'show' => 'show.cpc.module_configuration_catalogs',
                'edit' => 'edit.cpc.module_configuration_catalogs',
                'update' => 'update.edit.cpc.module_configuration_catalogs',
                'destroy' => 'destroy.cpc.module_configuration_catalogs'
            ]
        ]);

        // Spending Guide
        Route::get('/spending_guide/data', [SpendingGuideController::class, 'data'])->name('data.index.spending_guide.module_configuration_catalogs');
        Route::put('/spending_guide/status/{id}', [SpendingGuideController::class, 'status'])->name('status.spending_guide.module_configuration_catalogs');
        Route::get('/spending_guide/create/addressing/{id}',
            [SpendingGuideController::class, 'loadByParent'])->name('children.create.spending_guide.module_configuration_catalogs');
        Route::get('/spending_guide/create/level/{level}',
            [SpendingGuideController::class, 'loadByLevels'])->name('level.create.spending_guide.module_configuration_catalogs');

        Route::resource('spending_guide', SpendingGuideController::class, [
            'parameters' => ['spending_guide' => 'id'],
            'names' => [
                'index' => 'index.spending_guide.module_configuration_catalogs',
                'create' => 'create.spending_guide.module_configuration_catalogs',
                'store' => 'store.create.spending_guide.module_configuration_catalogs',
                'show' => 'show.spending_guide.module_configuration_catalogs',
                'edit' => 'edit.spending_guide.module_configuration_catalogs',
                'update' => 'update.edit.spending_guide.module_configuration_catalogs',
                'destroy' => 'destroy.spending_guide.module_configuration_catalogs'
            ]
        ]);

        // Budget Classifier
        Route::get('/budget_classifiers/data', [BudgetClassifierController::class, 'data'])->name('data.index.budget_classifiers.module_configuration_catalogs');
        Route::put('/budget_classifiers/status/{id}', [BudgetClassifierController::class, 'status'])->name('status.budget_classifiers.module_configuration_catalogs');

        Route::resource('budget_classifiers', BudgetClassifierController::class, [
            'parameters' => ['budget_classifiers' => 'id'],
            'names' => [
                'index' => 'index.budget_classifiers.module_configuration_catalogs',
                'create' => 'create.budget_classifiers.module_configuration_catalogs',
                'store' => 'store.create.budget_classifiers.module_configuration_catalogs',
                'show' => 'show.budget_classifiers.module_configuration_catalogs',
                'edit' => 'edit.budget_classifiers.module_configuration_catalogs',
                'update' => 'update.edit.budget_classifiers.module_configuration_catalogs',
                'destroy' => 'destroy.budget_classifiers.module_configuration_catalogs'
            ]
        ]);

        // Measure Units
        Route::get('/measure_units/data', [MeasureUnitController::class, 'data'])->name('data.index.measure_units.module_configuration_catalogs');
        Route::put('/measure_units/status/{id}', [MeasureUnitController::class, 'status'])->name('status.index.measure_units.module_configuration_catalogs');

        Route::resource('measure_units', MeasureUnitController::class, [
            'parameters' => ['measure_units' => 'id'],
            'names' => [
                'index' => 'index.measure_units.module_configuration_catalogs',
                'create' => 'create.measure_units.module_configuration_catalogs',
                'store' => 'store.create.measure_units.module_configuration_catalogs',
                'edit' => 'edit.measure_units.module_configuration_catalogs',
                'update' => 'update.edit.measure_units.module_configuration_catalogs',
                'destroy' => 'destroy.measure_units.module_configuration_catalogs'
            ]
        ])->except(['show']);

        // Institution
        Route::get('/institution/data', 'Business\Catalogs\InstitutionController@data')->name('data.index.institution.module_configuration_catalogs');
        Route::put('/institution/status/{id}', 'Business\Catalogs\InstitutionController@status')->name('status.index.institution.module_configuration_catalogs');

        Route::resource('institution', 'Business\Catalogs\InstitutionController', [
            'parameters' => ['institution' => 'id'],
            'names' => [
                'index' => 'index.institution.module_configuration_catalogs',
                'create' => 'create.institution.module_configuration_catalogs',
                'store' => 'store.create.institution.module_configuration_catalogs',
                'edit' => 'edit.institution.module_configuration_catalogs',
                'update' => 'update.edit.institution.module_configuration_catalogs',
                'destroy' => 'destroy.institution.module_configuration_catalogs'
            ]
        ])->except(['show']);

        // Activity Type
        Route::get('/activity_type/data', 'Business\Catalogs\ActivityTypeController@data')->name('data.index.activity_type.module_configuration_catalogs');

        Route::resource('activity_type', 'Business\Catalogs\ActivityTypeController', [
            'parameters' => ['activity_type' => 'id'],
            'names' => [
                'index' => 'index.activity_type.module_configuration_catalogs',
                'create' => 'create.activity_type.module_configuration_catalogs',
                'store' => 'store.create.activity_type.module_configuration_catalogs',
                'edit' => 'edit.activity_type.module_configuration_catalogs',
                'update' => 'update.edit.activity_type.module_configuration_catalogs',
                'destroy' => 'destroy.activity_type.module_configuration_catalogs'
            ]
        ])->except(['show']);

        // Reasons
        Route::get('/reasons/data', 'Business\Catalogs\ReasonController@data')->name('data.index.reasons.module_configuration_catalogs');

        Route::resource('reasons', 'Business\Catalogs\ReasonController', [
            'parameters' => ['reasons' => 'id'],
            'names' => [
                'index' => 'index.reasons.module_configuration_catalogs',
                'create' => 'create.reasons.module_configuration_catalogs',
                'store' => 'store.create.reasons.module_configuration_catalogs',
                'edit' => 'edit.reasons.module_configuration_catalogs',
                'update' => 'update.edit.reasons.module_configuration_catalogs',
                'destroy' => 'destroy.reasons.module_configuration_catalogs'
            ]
        ])->except(['show']);
    }
    );

    /**
     * Reports
     */
    Route::group(
        [
            'prefix' => 'reports',
            'middleware' => ['auth', 'route']
        ],
        function () {

            // Reports index
            Route::resource('reports', 'Business\Reports\ReportsController', [
                'names' => [
                    'index' => 'index.reports'
                ]
            ])->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

            // PPI report
            Route::get('/ppi_report/index', [PlanningReportsController::class, 'ppiReport'])->name('index.ppi.reports');
            Route::get('/ppi_report/data', [PlanningReportsController::class, 'ppiData'])->name('data.index.ppi.reports');

            // Annual Budget Planning report
            Route::get('/annual_budget_planning_report/index', [PlanningReportsController::class, 'annualBudgetPlanningReport'])->name('annual_budget_planning.reports');
            Route::get('/annual_budget_planning_report/data', [PlanningReportsController::class, 'annualBudgetPlanningData'])->name('data.annual_budget_planning.reports');
            Route::get('/annual_budget_planning_report/export/{fiscalYearId}/{departmentId?}',
                [PlanningReportsController::class, 'annualBudgetPlanningExport'])->name('export.annual_budget_planning.reports');

            // Matrix PS and PND report
            Route::get('/psandpnd_report/index', [PlanningReportsController::class, 'pndAndpsReport'])->name('index.psandpnd.reports');

            // Matrix PDOT and PEI report
            Route::get('/pdotandpei_report/index', [PlanningReportsController::class, 'peiAndpdotReport'])->name('index.pdotandpei.reports');
            Route::get('/pdotandpei_report/index/export', [PlanningReportsController::class, 'peiAndpdotReportExportXls'])->name('export.index.pdotandpei.reports');

            // Matrix PND and PDOT report
            Route::get('/pndandpdot_report/index', [PlanningReportsController::class, 'pndAndpdotReport'])->name('index.pndandpdot.reports');
            Route::get('/pndandpdot_report/index/export', [PlanningReportsController::class, 'pndAndPDOTReportExportXls'])->name('export.index.pndandpdot.reports');

            // POA
            Route::get('/poa_report/index', [PlanningReportsController::class, 'poaReport'])->name('index.poa.reports');
            Route::get('/poa_report/index/view', [PlanningReportsController::class, 'poaReportView'])->name('view.index.poa.reports');
            Route::post('/poa_report/index/data', [PlanningReportsController::class, 'poaData'])->name('data.index.poa.reports');
            Route::get('/poa_report/export_xls/', [PlanningReportsController::class, 'poaExportXls'])->name('export.index.poa.reports');

            // PAC
            Route::get('/pac_report/index', [PlanningReportsController::class, 'pacReport'])->name('index.pac.reports');
            Route::get('/pac_report/index/view', [PlanningReportsController::class, 'pacReportView'])->name('view.index.pac.reports');
            Route::get('/pac_report/index/data', [PlanningReportsController::class, 'pacData'])->name('data.index.pac.reports');
            Route::get('/pac_report/export_xls/{fiscalYearId}', [PlanningReportsController::class, 'pacExportXls'])->name('export_xls.index.pac.reports');

            // PEI Programmatic Structure
            Route::get('/pei_structure_report/index', [PlanningReportsController::class, 'peiStructureIndex'])->name('pei_structure_report.reports');
            Route::get('/pei_structure_report/data/{fiscalYearId}', [PlanningReportsController::class, 'peiStructureReport'])->name('data.pei_structure_report.reports');
            Route::post('/pei_structure_report/export/{fiscalYearId}',
                [PlanningReportsController::class, 'peiStructureExport'])->name('export.pei_structure_report.reports');

            // Sectoral Plan Matrix
            Route::get('/sectorial_plans_report/index', [PlanningReportsController::class, 'sectorialPlansIndex'])->name('sectorial_plans_matrix.reports');
            Route::get('/sectorial_plans_report/export', [PlanningReportsController::class, 'sectorialPlansExport'])->name('export.sectorial_plans_matrix.reports');

            // Agreement for Results
            Route::get('/agreement_for_results_report/index', [PlanningReportsController::class, 'agreementForResultsIndex'])->name('agreement_for_results.reports');
            Route::get('/agreement_for_results_report/servant', [PlanningReportsController::class, 'servantSearch'])->name('servant_search.agreement_for_results.reports');
            Route::get('/agreement_for_results_report/data', [PlanningReportsController::class, 'agreementForResultsData'])->name('data.agreement_for_results.reports');
            Route::get('/agreement_for_results_report/export',
                [PlanningReportsController::class, 'agreementForResultsExport'])->name('export.agreement_for_results.reports');

            // Seguimiento POA
            Route::get('/poa_tracking_report/index', [TrackingReportsController::class, 'poaReport'])->name('index.poa_tracking.reports');
            Route::post('/poa_tracking_report/index/data', [TrackingReportsController::class, 'poaData'])->name('data.index.poa_tracking.reports');
            Route::get('/poa_tracking_report/index/projects/{executingUnitId}',
                [TrackingReportsController::class, 'loadProjects'])->name('projects.index.poa_tracking.reports');
            Route::get('/poa_tracking_report/index/export', [TrackingReportsController::class, 'poaReportExport'])->name('export.index.poa_tracking.reports');

            // PAC
            Route::get('/pac_tracking_report/index', [TrackingReportsController::class, 'pacReportIndex'])->name('index.pac_tracking.reports');
            Route::get('/pac_tracking_report/index/data', [TrackingReportsController::class, 'pacData'])->name('data.index.pac_tracking.reports');
            Route::get('/pac_tracking_report/export_xls/{fiscalYearId}', [TrackingReportsController::class, 'pacExportXls'])->name('export.index.pac_tracking.reports');

            // POA Physical and Budget
            Route::get('/poa_tracking_physical_and_budget/poa_physical_budget',
                [TrackingReportsController::class, 'poaPhysicalBudget'])->name('poa_tracking_physical_and_budget.reports');
            Route::get('/poa_tracking_physical_and_budget/poa_physical_budget/data',
                [TrackingReportsController::class, 'poaPhysicalBudgetData'])->name('data.poa_tracking_physical_and_budget.reports');
            Route::get('/poa_tracking_physical_and_budget/export_xls/{fiscalYearId}/{executingUnitId}',
                [TrackingReportsController::class, 'poaPhysicalBudgetExport'])->name('export_xls.poa_tracking_physical_and_budget.reports');

            // Executive summary report
            Route::get('/executive_summary/index', [PlanningReportsController::class, 'executiveSummaryView'])->name('index.executive_summary.reports');
            Route::get('/executive_summary/data/{fiscalYearId}', [PlanningReportsController::class, 'executiveSummaryData'])->name('data.index.executive_summary.reports');
            Route::get('/executive_summary/data_export/{fiscalYearId}',
                [PlanningReportsController::class, 'dataExecutiveSummaryExportView'])->name('data_export.index.executive_summary.reports');

            // Budget Card
            Route::get('/budget_card/index', [PlanningReportsController::class, 'budgetCardIndex'])->name('budget_card.reports');
            Route::get('/budget_card/index/data', [PlanningReportsController::class, 'budgetCardData'])->name('data.budget_card.reports');
            Route::get('/budget_card/export', [PlanningReportsController::class, 'budgetCardExport'])->name('export.budget_card.reports');
            Route::get('/budget_card/levels/{year}/{type}', [PlanningReportsController::class, 'structureLevels'])->name('levels.budget_card.reports');
            Route::get('/budget_card/index/budget_item/{year}/{account}', [PlanningReportsController::class, 'budgetItemMovements'])->name('account.budget_card.reports');
            Route::get('/budget_card/index/budget_item_data', [PlanningReportsController::class, 'budgetItemMovementsData'])->name('data.account.budget_card.reports');

            // Budget Card Expenses
            Route::get('/budget_card_expenses/index', [PlanningReportsController::class, 'budgetCardExpensesIndex'])->name('index.budget_card_expenses.reports');
            Route::get('/budget_card_expenses/index/data', [PlanningReportsController::class, 'budgetCardExpensesData'])->name('data.index.budget_card_expenses.reports');
            Route::get('/budget_card_expenses/index/export',
                [PlanningReportsController::class, 'budgetCardExpensesExport'])->name('export.index.budget_card_expenses.reports');

            // Projects repository
            Route::get('/projects_repository/index', [PlanningReportsController::class, 'projectsRepositoryIndex'])->name('projects_repository.reports');
            Route::get('/projects_repository/data', [PlanningReportsController::class, 'projectsRepositoryData'])->name('data.projects_repository.reports');
            Route::get('/projects_repository/export', [PlanningReportsController::class, 'projectsRepositoryExport'])->name('export.projects_repository.reports');

            // Physical advance report
            Route::get('/physical_advance_report/index', [ExecutionReportsController::class,'physicalAdvanceIndex'])->name('physical_advance.reports');
            Route::get('/physical_advance_report/data', [ExecutionReportsController::class,'physicalAdvanceReport'])->name('data.physical_advance.reports');

            // Incomes-Expenses By Source-Planning
            Route::get('/income_expense/index', [PlanningReportsController::class, 'incomesExpensesBySourceIndex'])->name('incomes_expenses.reports');
            Route::get('/income_expense/index/data/{fiscalYearId}',
                [PlanningReportsController::class, 'incomesExpensesBySourcedata'])->name('data.incomes_expenses.reports');

            // Incomes-Expenses By Source-Execution
            Route::get('/execution/income_expense/index', [ExecutionReportsController::class,'incomesExpensesBySourceIndex'])->name('incomes_expenses_execution.reports');

            // Activities quarterly execution
            Route::get('/activities_quarterly_execution/index',
                [PlanningReportsController::class, 'activitiesQuarterlyExecutionReport'])->name('activities_quarterly_execution.reports');
            Route::get('/activities_quarterly_execution/data',
                [PlanningReportsController::class, 'activitiesQuarterlyExecutionData'])->name('data.activities_quarterly_execution.reports');
            Route::get('/activities_quarterly_execution/project_search',
                [PlanningReportsController::class, 'projectSearch'])->name('project_search.activities_quarterly_execution.reports');

            // LOTAIP
            Route::get('/lotaip/index', [PlanningReportsController::class, 'lotaipIndex'])->name('lotaip.reports');
            Route::get('/lotaip/index/data/{fiscalYearId}', [PlanningReportsController::class, 'lotaipData'])->name('data.lotaip.reports');
            Route::get('/lotaip/index/export/{fiscalYearId}', [PlanningReportsController::class, 'lotaipDataExport'])->name('export.lotaip.reports');

            // Execution Projects
            Route::get('/execution/projects/index', [TrackingReportsController::class, 'executionProjectsIndex'])->name('index.execution_projects.reports');
            Route::get('/execution/projects/index/export',
                [TrackingReportsController::class, 'executionProjectsIndexExport'])->name('export.index.execution_projects.reports');

            // Planning Execution Projects
            Route::get('/execution/planning/projects/index',
                [TrackingReportsController::class, 'planningExecutionProjectsIndex'])->name('index.planning_execution_projects.reports');
            Route::get('/execution/planning/projects/index/export',
                [TrackingReportsController::class, 'planningExecutionProjectsExport'])->name('export.index.planning_execution_projects.reports');

            // Budget Adjustment
            Route::get('/budget_adjustment_report/index', [PlanningReportsController::class, 'budgetAdjustmentView'])->name('budget_adjustment.reports');
            Route::get('/budget_adjustment_report/data/{fiscalYearId}', [PlanningReportsController::class, 'budgetAdjustmentData'])->name('data.budget_adjustment.reports');

            // Projects Dashboard
            Route::get('/projects/dashboard', [ProjectTrackingController::class, 'dashboard'])->name('project_dashboard.control_panel');
            Route::get('/projects/dashboard/project/budget/monthly/{projectFiscalYearId}',
                [ProjectTrackingController::class, 'filterBudgetProjects'])->name('budget_monthly.project_dashboard.control_panel');
            Route::get('/projects/dashboard/project/budget/criteria/{criteria}',
                [ProjectTrackingController::class, 'filterBudgetCriteria'])->name('criteria.project_dashboard.control_panel');
            Route::get('/projects/dashboard/project/physical/{projectFiscalYearId}',
                [ProjectTrackingController::class, 'filterPhysicalProjects'])->name('physical.project_dashboard.control_panel');

            // Dashboards
            Route::get('/planning/dashboard/budget/detail/{type}',
                'Business\Reports\DashboardController@detailsBudget')->name('details.budget.dashboard.control_panel');
            Route::get('/planning/dashboard/budget/category/{type}/{category}',
                'Business\Reports\DashboardController@budgetByCategory')->name('category.budget.dashboard.control_panel');
            Route::get('/planning/dashboard/budget/execution',
                'Business\Reports\DashboardController@budgetMonthlyExecution')->name('execution.budget.dashboard.control_panel');
            Route::get('/planning/dashboard/administrative/chart_1',
                'Business\Reports\DashboardController@adminActByStatus')->name('chart_1.administrative.dashboard.control_panel');
            Route::get('/planning/dashboard/administrative/chart_2',
                'Business\Reports\DashboardController@adminActByPriority')->name('chart_2.administrative.dashboard.control_panel');
            Route::get('/planning/dashboard/administrative/chart_3',
                'Business\Reports\DashboardController@adminActByResponsibleUnit')->name('chart_3.administrative.dashboard.control_panel');

            //Dashboard projects
            Route::get('/planning/dashboard/project/detail',
                'Business\Reports\DashboardController@detailsProjects')->name('details.projects.dashboard.control_panel');

            Route::get('/planning/dashboard/project/execution',
                'Business\Reports\DashboardController@projectMonthlyExecution')->name('execution.projects.dashboard.control_panel');

            Route::get('/planning/dashboard/project/category',
                'Business\Reports\DashboardController@projectByCategory')->name('category.projects.dashboard.control_panel');


            // Ongoing Projects
            Route::get('/ongoing/projects/index', [TrackingReportsController::class, 'ongoingProjectIndex'])->name('ongoing_projects.reports');
            Route::get('/ongoing/projects/data', [TrackingReportsController::class, 'ongoingProjectData'])->name('data.ongoing_projects.reports');
            Route::get('/ongoing/projects/export', [TrackingReportsController::class, 'ongoingProjectExport'])->name('export.ongoing_projects.reports');

            // Projects Activities POA
            Route::get('/projetcs_activities_poa/index', [PlanningReportsController::class, 'projectActivityPOAIndex'])->name('index.projects_activities.reports');
            Route::get('/projetcs_activities_poa/index/data/{executingUnitId}',
                [PlanningReportsController::class, 'projectActivityPOAIndexData'])->name('data.index.projects_activities.reports');

            // Projects Activities POA
            Route::get('/planning_accrued/index', [TrackingReportsController::class, 'planningAccruedIndex'])->name('index.planning_accrued.reports');
            Route::get('/planning_accrued/index/data/{executingUnitId}',
                [TrackingReportsController::class, 'planningAccruedData'])->name('data.index.planning_accrued.reports');

            //Report Task/Milestone
            Route::get('/task_milestone/index', [TrackingReportsController::class, 'taskMilestone'])->name('index.task_milestone.reports');
            Route::get('/task_milestone/index/data', [TrackingReportsController::class, 'taskMilestoneData'])->name('data.index.task_milestone.reports');
            Route::get('/task_milestone/index/export', [TrackingReportsController::class, 'exportTaskMilestoneData'])->name('export.index.task_milestone.reports');

            //Report Partitipatory budget
            Route::get('/participatory_budget/index', [TrackingReportsController::class, 'participatoryBudget'])->name('index.participatory_budget.reports');
            Route::get('/participatory_budget/index/data', [TrackingReportsController::class, 'participatoryBudgetData'])->name('data.index.participatory_budget.reports');
            Route::get('/participatory_budget/index/export',
                [TrackingReportsController::class, 'exportParticipatoryBudgetData'])->name('export.index.participatory_budget.reports');

            //Report Riks Mitiggation Plan
            Route::get('/risk_mitigation_plan/index', [TrackingReportsController::class, 'riskMitigationPlan'])->name('index.risk_mitigation_plan.reports');
            Route::get('/risk_mitigation_plan/index/data', [TrackingReportsController::class, 'riskMitigationPlanData'])->name('data.index.risk_mitigation_plan.reports');
            Route::get('/risk_mitigation_plan/index/export',
                [TrackingReportsController::class, 'exportRiskMitigationPlanData'])->name('export.index.risk_mitigation_plan.reports');

            // Admin Activities
            Route::get('/admin_activities/index', [TrackingReportsController::class, 'adminActivities'])->name('index.admin_activities.reports');
            Route::get('/admin_activities/index/data', [TrackingReportsController::class, 'adminActivitiesData'])->name('data.index.admin_activities.reports');
            Route::get('/admin_activities/index/export', [TrackingReportsController::class, 'exportAdminActivitiesData'])->name('export.index.admin_activities.reports');

            // Admin Activities Responsible Unit
            Route::get('/admin_activities_responsible_unit/index',
                [TrackingReportsController::class, 'adminActivitiesResponsibleUnit'])->name('index.admin_activities_responsible_unit.reports');


            // Avance de proyectos de inversión de lo ejecutado y lo programado por cuatrimestre
            Route::get('/progress_investment_projects_executed_programmed/index',
                [TrackingReportsController::class, 'progressInvestmentProjectsExecutedProgrammed'])->name('index.progress_investment_projects_executed_programmed.reports');

            // Avance de proyectos de inversión de lo ejecutado y lo programado por fecha
            Route::get('/progress_investment_projects_executed_programmed2/index',
                [TrackingReportsController::class, 'progressInvestmentProjectsExecutedProgrammedbyDate'])->name('index.progress_investment_projects_executed_programmed2.reports');

            // Avance de proyectos de inversión
            Route::get('/investment_projects/index', [TrackingReportsController::class, 'progressInvestmentProject'])->name('index.progress_investment_project.reports');

            // Admin Activities and Budget By Responsible Unit
            Route::get('/admin_activities_budget_responsible_unit/index',
                [TrackingReportsController::class, 'adminActivitiesBudgetResponsibleUnit'])->name('index.admin_activities_budget.reports');

            // Executive Progress Project
            Route::get('/executive_progress_project/index',
                [TrackingReportsController::class, 'executiveProgressProject'])->name('index.executive_progress_project.reports');
            Route::get('/executive_progress_project/index/data',
                [TrackingReportsController::class, 'executiveProgressProjectData'])->name('data.index.executive_progress_project.reports');

            // Executive Progress Responsible Units
            Route::get('/executive_progress_unit/index',
                [TrackingReportsController::class, 'executiveProgressUnit'])->name('index.executive_progress_unit.reports');

            // Admin and Projects Activities
            Route::get('/project_admin_activities/index', [TrackingReportsController::class, 'projectAdminActivitiesIndex'])->name('index.project_admin_activities.reports');
            Route::get('/project_admin_activities/index/admin/data',
                [TrackingReportsController::class, 'reportAdminActivitiesData'])->name('data_admin_activity.index.project_admin_activities.reports');
            Route::get('/project_admin_activities/index/project/data',
                [TrackingReportsController::class, 'reportProjectActivitiesData'])->name('data_project_activity.index.project_admin_activities.reports');
            Route::get('/project_admin_activities/index/export',
                [TrackingReportsController::class, 'reportProjectActivitiesExport'])->name('export.index.project_admin_activities.reports');

            //Reforms and Certificactions
            Route::get('/reform_and_certifications/index', [TrackingReportsController::class, 'reformCertificationIndex'])->name('index.reforms_and_certifications.reports');
            Route::get('/reform_and_certifications/report/{projectId}',
                [TrackingReportsController::class, 'reformCertificationIndexExport'])->name('report.reforms_and_certifications.reports');
            Route::get('/reform_and_certifications/report2/{projectId}',
                [TrackingReportsController::class, 'reformCertificationIndexExport2'])->name('report2.reforms_and_certifications.reports');
            Route::get('/reform_and_certifications/index/data',
                [TrackingReportsController::class, 'reformCertificationData'])->name('data.index.reforms_and_certifications.reports');
            Route::get('/reform_and_certifications/index/data2',
                [TrackingReportsController::class, 'reformCertificationData2'])->name('data2.index.reforms_and_certifications.reports');

            //Indicators
            Route::get('/indicators/export', [TrackingReportsController::class, 'projectComponentsIndicatorsExport'])->name('index.indicators.reports');

        }
    );

    /* ---------------- */
    /* Global Functions */
    /* ---------------- */

    Route::group([
        'middleware' => ['auth']
    ],
        function () {
            Route::get('/configuration/checkuniquefield', 'System\UtilsController@checkUniqueField')->name('checkuniquefield');
        }
    );

    /* ------------- */
    /* Configuration */
    /* ------------- */

    Route::group([
        'prefix' => 'config',
        'middleware' => ['auth', 'acl'],
        'is' => 'developer'
    ],
        function () {

            // permissions
            Route::get('/permissions/data', 'Configuration\PermissionController@data')->name('data.index.permissions.configuration');
            Route::delete('/permissions/bulk/destroy', 'Configuration\PermissionController@bulkDestroy')->name('bulk.destroy.permissions.configuration');
            Route::resource('permissions', 'Configuration\PermissionController', [
                'parameters' => ['permissions' => 'id'],
                'names' => [
                    'index' => 'index.permissions.configuration',
                    'create' => 'create.permissions.configuration',
                    'store' => 'store.create.permissions.configuration',
                    'show' => 'show.permissions.configuration',
                    'edit' => 'edit.permissions.configuration',
                    'update' => 'update.edit.permissions.configuration',
                    'destroy' => 'destroy.permissions.configuration',
                ]
            ]);

            // roles
            Route::get('/roles/data', 'Configuration\RoleController@data')->name('data.index.roles.configuration');
            Route::put('/roles/editable/{id}', 'Configuration\RoleController@editable')->name('editable.roles.configuration');
            Route::put('/roles/permissions', 'Configuration\RoleController@permissions')->name('permissions.show.roles.configuration');
            Route::put('/roles/permissions/all', 'Configuration\RoleController@allPermissions')->name('all.permissions.show.roles.configuration');

            Route::resource('roles', 'Configuration\RoleController', [
                'parameters' => ['roles' => 'id'],
                'names' => [
                    'index' => 'index.roles.configuration',
                    'show' => 'show.roles.configuration',
                ]
            ]);

            // menus
            Route::get('/menus/data', 'Configuration\MenuController@data')->name('data.index.menus.configuration');
            Route::delete('/menus/bulk/destroy', 'Configuration\MenuController@bulkDestroy')->name('bulk.destroy.menus.configuration');
            Route::put('/menus/status/{id}', 'Configuration\MenuController@status')->name('status.menus.configuration');
            Route::put('/menus/bulk/status', 'Configuration\MenuController@bulkStatus')->name('bulk.status.menus.configuration');
            Route::resource('menus', 'Configuration\MenuController', [
                'parameters' => ['menus' => 'id'],
                'names' => [
                    'index' => 'index.menus.configuration',
                    'create' => 'create.menus.configuration',
                    'store' => 'store.create.menus.configuration',
                    'show' => 'show.menus.configuration',
                    'edit' => 'edit.menus.configuration',
                    'update' => 'update.edit.menus.configuration',
                    'destroy' => 'destroy.menus.configuration',
                ]
            ]);

            // ui
            Route::get('/ui/edit', 'Configuration\UIController@edit')->name('edit.ui.configuration');
            Route::put('/ui/edit/update', 'Configuration\UIController@update')->name('update.edit.ui.configuration');

            // settings
            Route::get('/settings/index', 'Configuration\SettingController@index')->name('index.settings.configuration');
            Route::get('/settings/data', 'Configuration\SettingController@data')->name('data.index.settings.configuration');
            Route::get('/settings/edit/{id}', 'Configuration\SettingController@edit')->name('edit.settings.configuration');
            Route::put('/settings/update/{id}', 'Configuration\SettingController@update')->name('update.edit.settings.configuration');
        }
    );

    /* Planning with budget adjustment controls */
    Route::group(
        [
            'prefix' => 'planning',
            'middleware' => ['auth', 'route', 'budget.adjustment']
        ],
        function () {

            // Project Fiscal Years
            Route::get('/project_fiscal_years/index', [ProjectFiscalYearController::class,'index'])->name('index.projects.plans_management');
            Route::get('/project_fiscal_years/data', [ProjectFiscalYearController::class,'data'])->name('data.index.projects.plans_management');
            Route::put('/project_fiscal_years/status/{id}/{project_fiscal_year_id}',
                [ProjectFiscalYearController::class,'status'])->name('status.projects.plans_management');
            Route::get('/project_fiscal_years/rejections/log', [ProjectFiscalYearController::class,'rejectionsLog'])->name('rejections_log.projects.plans_management');
            Route::get('/project_fiscal_years/rejections/log/data',
                [ProjectFiscalYearController::class,'rejectionsLogData'])->name('data.rejections_log.projects.plans_management');

            // Projects
            Route::get('/projects/profile/edit/{id}', [\App\Http\Controllers\Business\Planning\ProjectController::class,'editProfile'])->name('edit.profile.projects.plans_management');
            Route::put('/projects/profile/update/{id}', [\App\Http\Controllers\Business\Planning\ProjectController::class,'update'])->name('update.edit.profile.projects.plans_management');
            Route::get('/projects/profile/users/executing_unit/{departmentId}',
                [\App\Http\Controllers\Business\Planning\ProjectController::class,'loadUsers'])->name('loadusers.edit.profile.projects.plans_management');
            Route::get('/projects/logic_frame/edit/{id}', [\App\Http\Controllers\Business\Planning\ProjectController::class,'editLogicFrame'])->name('modify.logic_frame.projects.plans_management');

            Route::get('/project/logic_frame/components/show/{id}',
                [LogicalFrameController::class,'logicFrameShow'])->name('show.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/create/{projectId}',
                [LogicalFrameController::class,'create'])->name('create.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/edit/{id}',
                [LogicalFrameController::class,'edit'])->name('edit.components.logic_frame.projects.plans_management');
            Route::post('/project/logic_frame/components/update/edit/{componentId}',
                [LogicalFrameController::class,'update'])->name('update.edit.components.logic_frame.projects.plans_management');
            Route::post('/project/logic_frame/components/create/store/{componentId}',
                [LogicalFrameController::class,'store'])->name('store.create.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/destroy/{componentId}',
                [LogicalFrameController::class,'destroy'])->name('destroy.components.logic_frame.projects.plans_management');

            Route::get('/project/logic_frame/indicators/show/{indicatorId}',
                [LogicalFrameController::class,'showFullIndicator'])->name('show.full_indicator.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/indicators/create/{projectId}',
                [LogicalFrameController::class,'createFullIndicator'])->name('create.full_indicator.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/indicators/edit/{projectId}',
                [LogicalFrameController::class,'editFullIndicator'])->name('edit.full_indicator.logic_frame.projects.plans_management');
            Route::post('/project/logic_frame/indicators/store/',
                [LogicalFrameController::class,'storeFullIndicator'])->name('store.create.full_indicator.logic_frame.projects.plans_management');
            Route::put('/project/logic_frame/indicators/update/{indicatorId}',
                [LogicalFrameController::class,'updateFullIndicator'])->name('update.edit.full_indicator.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/indicators/delete/{indicatorId}',
                [LogicalFrameController::class,'destroyIndicator'])->name('delete.full_indicator.logic_frame.projects.plans_management');

            Route::get('/project/logic_frame/components/indicator/show/{id}',
                [LogicalFrameController::class,'showIndicator'])->name('show.indicator.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/indicator/build/{componentId}',
                [LogicalFrameController::class,'createIndicator'])->name('build.indicator.components.logic_frame.projects.plans_management');
            Route::post('/project/logic_frame/components/indicators/store/',
                [LogicalFrameController::class,'storeIndicator'])->name('store.build.indicator.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/indicators/edit/{indicatorId}',
                [LogicalFrameController::class,'editIndicator'])->name('edit.indicator.components.logic_frame.projects.plans_management');
            Route::put('/project/logic_frame/components/indicators/update/{indicatorId}',
                [LogicalFrameController::class,'updateIndicator'])->name('update.edit.indicator.components.logic_frame.projects.plans_management');
            Route::get('/project/logic_frame/components/indicators/delete/{indicatorId}',
                [LogicalFrameController::class,'destroyIndicatorComponent'])->name('delete.indicator.components.logic_frame.projects.plans_management');
            Route::put('/projects/logic_frame/update/{id}', [\App\Http\Controllers\Business\Planning\ProjectController::class,'update'])->name('update.modify.logic_frame.projects.plans_management');

            // Project Activities
            Route::get('/projects/{projectId}/activities/create',
                'Business\Planning\ActivityProjectFiscalYearController@create')->name('create.activities.projects.plans_management');
            Route::post('/projects/activities/create/store',
                'Business\Planning\ActivityProjectFiscalYearController@store')->name('store.create.activities.projects.plans_management');
            Route::get('/projects/activities/edit/{id}', 'Business\Planning\ActivityProjectFiscalYearController@edit')->name('edit.activities.projects.plans_management');
            Route::put('/projects/activities/update/{id}',
                'Business\Planning\ActivityProjectFiscalYearController@update')->name('update.edit.activities.projects.plans_management');
            Route::delete('/projects/activities/destroy/{id}',
                'Business\Planning\ActivityProjectFiscalYearController@destroy')->name('destroy.activities.projects.plans_management');
            Route::get('/projects/{id}/activities/index', 'Business\Planning\ActivityProjectFiscalYearController@index')->name('list.activities.projects.plans_management');
            Route::get('/projects/{projectId}/activities/data',
                'Business\Planning\ActivityProjectFiscalYearController@data')->name('data.list.activities.projects.plans_management');
            Route::post('/projects/{projectId}/activities/index/budget_planning',
                'Business\Planning\ActivityProjectFiscalYearController@storeBudgetPlanning')->name('store_budget_planning.list.activities.projects.plans_management');

            // Budget Items
            Route::get('/projects/activities/budget_items/{activityId}',
                'Business\Planning\ActivityProjectFiscalYearController@budgetItems')->name('index.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/{activityId}/items/data',
                'Business\Planning\BudgetItemController@data')->name('data.index.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/{activityId}/items/create',
                'Business\Planning\BudgetItemController@create')->name('create.items.activities.projects.plans_management');
            Route::post('/projects/activities/show/{activityId}/items/store',
                'Business\Planning\BudgetItemController@store')->name('store.create.items.activities.projects.plans_management');
            Route::get('/projects/activities/show/items/{id}/edit/',
                'Business\Planning\BudgetItemController@edit')->name('edit.items.activities.projects.plans_management');
            Route::put('/projects/activities/show/items/{budgetItemId}/update',
                'Business\Planning\BudgetItemController@update')->name('update.edit.items.activities.projects.plans_management');
            Route::delete('/projects/activities/show/items/{id}/destroy',
                'Business\Planning\BudgetItemController@destroy')->name('destroy.items.activities.projects.plans_management');

            // Public Purchases
            Route::get('/projects/activities/show/items/{id}/{activityType?}/purchases/index',
                'Business\Planning\PublicPurchaseController@index')->name('index.purchases.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/items/{budgetItemId}/{activityType?}/purchases/data',
                'Business\Planning\PublicPurchaseController@data')->name('data.index.purchases.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/items/{budgetItemId}/{activityType?}/purchases/create',
                'Business\Planning\PublicPurchaseController@create')->name('create.purchases.items.activities.projects.plans_management');

            Route::post('/projects/activities/show/items/{budgetItemId}/purchases/store',
                'Business\Planning\PublicPurchaseController@store')->name('store.create.purchases.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/items/{id}/{activityType?}/purchases/modify',
                'Business\Planning\PublicPurchaseController@edit')->name('modify.purchases.items.activities.projects.plans_management');

            Route::put('/projects/activities/show/items/{purchaseId}/purchases/update',
                'Business\Planning\PublicPurchaseController@update')->name('update.modify.purchases.items.activities.projects.plans_management');

            Route::delete('/projects/activities/show/items/purchases/{id}/delete',
                'Business\Planning\PublicPurchaseController@destroy')->name('delete.purchases.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/items/cpc/search',
                'Business\Planning\PublicPurchaseController@cpcSearch')->name('cpc_search.purchases.items.activities.projects.plans_management');

            Route::get('/projects/activities/show/items/cpc/searchProcedures',
                'Business\Planning\PublicPurchaseController@searchProcedures')->name('search_procedures.purchases.items.activities.projects.plans_management');

            // Project Schedule
            Route::get('/projects/schedule/index/loadgantt', 'Business\Planning\ScheduleController@loadGantt')->name('load_gantt.index.schedule.projects.plans_management');
            Route::get('/projects/schedule/index/loadtable', 'Business\Planning\ScheduleController@loadTable')->name('load_table.index.schedule.projects.plans_management');
            Route::get('/projects/schedule/index/{id}', 'Business\Planning\ScheduleController@index')->name('index.schedule.projects.plans_management');
            Route::put('/projects/schedule/update', 'Business\Planning\ScheduleController@update')->name('update.schedule.projects.plans_management');
            Route::post('/projects/schedule/store', 'Business\Planning\ScheduleController@store')->name('store.schedule.projects.plans_management');
            Route::resource('schedule', 'Business\Planning\ScheduleController', [
                'parameters' => ['schedule' => 'id'],
                'names' => [
                    'destroy' => 'destroy.schedule.projects.plans_management'
                ]
            ])->except(['index', 'show', 'edit', 'update', 'create', 'store']);

            // Operational goals
            Route::get('/operational_goals/loadstructure', 'Business\Planning\OperationalGoalsController@loadStructure')->name('loadstructure.operational_goals.plans_management');

            Route::post('/operational_goals/indicator/store',
                'Business\Planning\OperationalGoalsController@storeFullIndicator')->name('store.create.indicator.operational_goals.plans_management');
            Route::get('/operational_goals/indicator/create/{operational_goal_id}',
                'Business\Planning\OperationalGoalsController@createFullIndicator')->name('create.indicator.operational_goals.plans_management');
            Route::get('/operational_goals/indicator/show/{id}',
                'Business\Planning\OperationalGoalsController@showFullIndicator')->name('show.indicator.operational_goals.plans_management');
            Route::put('/operational_goals/indicator/update/{id}',
                'Business\Planning\OperationalGoalsController@updateFullIndicator')->name('update.edit.indicator.operational_goals.plans_management');
            Route::get('/operational_goals/indicator/edit/{id}',
                'Business\Planning\OperationalGoalsController@editFullIndicator')->name('edit.indicator.operational_goals.plans_management');
            Route::delete('/operational_goals/indicator/destroy/{id}',
                'Business\Planning\OperationalGoalsController@destroyIndicator')->name('destroy.indicator.operational_goals.plans_management');

            Route::resource('operational_goals', 'Business\Planning\OperationalGoalsController', [
                'parameters' => ['operational_goals' => 'id'],
                'names' => [
                    'index' => 'index.operational_goals.plans_management',
                    'create' => 'create.operational_goals.plans_management',
                    'store' => 'store.create.operational_goals.plans_management',
                    'show' => 'show.operational_goals.plans_management',
                    'update' => 'update.edit.operational_goals.plans_management',
                    'edit' => 'edit.operational_goals.plans_management',
                    'destroy' => 'destroy.operational_goals.plans_management'
                ]
            ]);

            Route::get('/projects_review/logic_frame/components/edit/{projectId}',
                [LogicalFrameController::class,'editShow'])->name('edit.components.projects_review.plans_management');
            Route::get('/projects_review/logic_frame/components/indicators/edit/{indicatorId}',
                [LogicalFrameController::class,'editIndicatorShow'])->name('edit.indicator.components.logic_frame.projects_review.plans_management');

            //Project Review
            Route::get('/projects_review/index', 'Business\Planning\ProjectReviewController@index')->name('index.projects_review.plans_management');
            Route::get('/projects_review/data', 'Business\Planning\ProjectReviewController@data')->name('data.index.projects_review.plans_management');
            Route::get('/projects_review/profile/edit/{id}', 'Business\Planning\ProjectReviewController@editProfile')->name('edit.profile.projects_review.plans_management');
            Route::get('/projects_review/profile/users/executing_unit/{departmentId}',
                'Business\Planning\ProjectReviewController@loadUsers')->name('loadusers.edit.profile.projects_review.plans_management');
            Route::put('/projects_review/bulk/approve', 'Business\Planning\ProjectReviewController@bulkApprove')->name('bulk.approve.projects_review.plans_management');
            Route::get('/projects_review/bulk/reverse/observations',
                'Business\Planning\ProjectReviewController@observationsReverse')->name('observations.reverse.projects_review.plans_management');
            Route::put('/projects_review/bulk/reverse', 'Business\Planning\ProjectReviewController@bulkReverse')->name('bulk.reverse.projects_review.plans_management');

            Route::get('/projects_review/logic_frame/edit/{id}',
                'Business\Planning\ProjectReviewController@editLogicFrame')->name('modify.logic_frame.projects_review.plans_management');
            Route::get('/projects_review/logic_frame/components/show/{projectId}',
                [LogicalFrameController::class,'logicFrameShow'])->name('show.components.logic_frame.projects_review.plans_management');
            Route::get('/projects_review/logic_frame/indicators/show/{projectId}',
                'Business\Planning\ProjectReviewController@showFullIndicator')->name('show.full_indicator.projects_review.plans_management');
            Route::get('/projects_review/logic_frame/indicators/edit/{projectId}',
                'Business\Planning\ProjectReviewController@editFullIndicator')->name('edit.full_indicator.projects_review.plans_management');
            Route::get('/projects_review/rejections/log', 'Business\Planning\ProjectReviewController@rejectionsLog')->name('rejections_log.projects_review.plans_management');

            // Project Review Activities
            Route::get('/projects_review/{id}/activities/index',
                'Business\Planning\ActivityProjectFiscalYearController@indexShow')->name('list.activities.projects_review.plans_management');
            Route::get('/projects_review/{projectId}/activities/data',
                'Business\Planning\ActivityProjectFiscalYearController@dataShow')->name('data.list.activities.projects_review.plans_management');

            //Project Review Budget Items
            Route::get('/projects_review/activities/budget_items/{activityId}',
                'Business\Planning\ActivityProjectFiscalYearController@showBudgetItems')->name('items.activities.projects_review.plans_management');
            Route::get('/projects_review/activities/show/{activityId}/items/data',
                'Business\Planning\BudgetItemController@dataShow')->name('data.items.activities.projects_review.plans_management');

            // Project Review Public Purchases
            Route::get('/projects_review/activities/show/items/{budgetItemId}/purchases/index',
                'Business\Planning\PublicPurchaseController@indexShow')->name('purchases.items.activities.projects_review.plans_management');
            Route::get('/projects_review/activities/show/items/{budgetItemId}/purchases/data',
                'Business\Planning\PublicPurchaseController@dataShow')->name('data.purchases.items.activities.projects_review.plans_management');
            Route::get('/projects_review/activities/show/items/{purchaseId}/purchases/modify',
                'Business\Planning\PublicPurchaseController@show')->name('show.purchases.items.activities.projects_review.plans_management');

            //Project Review Schedule
            Route::get('/projects_review/schedule/index/loadtable',
                'Business\Planning\ScheduleController@loadTableShow')->name('load_table_show.schedule.projects_review.plans_management');
            Route::get('/projects_review/schedule/index/loadgantt',
                'Business\Planning\ScheduleController@loadGanttShow')->name('load_gantt_show.schedule.projects_review.plans_management');
            Route::get('/projects_review/schedule/index/{id}', 'Business\Planning\ScheduleController@indexShow')->name('index_show.schedule.projects_review.plans_management');

            Route::get('/projects_review/indexShow', [AttachmentsController::class, 'indexShow'])->name('indexshow.projects_review.plans_management');
            Route::get('/projects_review/indexShow/download/{id}', [AttachmentsController::class, 'download'])->name('download.indexshow.projects_review.plans_management');
            Route::get('/projects_review/attachments_roads_show',
                [AttachmentsController::class, 'attachmentsRoadsShow'])->name('attachments_roads_show.projects_review.plans_management');
            Route::get('/projects_review/attachments_roads_show/download/{id}',
                [AttachmentsController::class, 'downloadRoads'])->name('download.attachments_roads_show.projects_review.plans_management');

            // Prioritization
            Route::get('/prioritization/data', 'Business\Planning\PrioritizationController@data')->name('data.index.prioritization.plans_management');
            Route::get('/prioritization/handle', 'Business\Planning\PrioritizationController@handle')->name('handle.prioritization.plans_management');
            Route::get('/prioritization/show/{id}', 'Business\Planning\PrioritizationController@show')->name('show.prioritization.plans_management');
            Route::delete('/prioritization/destroy/{id}', 'Business\Planning\PrioritizationController@destroy')->name('destroy.prioritization.plans_management');

            Route::resource('prioritization', 'Business\Planning\PrioritizationController', [
                'parameters' => ['prioritization' => 'id'],
                'names' => [
                    'index' => 'index.prioritization.plans_management',
                    'create' => 'create.prioritization.plans_management',
                    'store' => 'store.create.prioritization.plans_management',
                    'edit' => 'edit.prioritization.plans_management',
                    'update' => 'update.edit.prioritization.plans_management',
                ]
            ])->except(['show', 'destroy']);

            // Income
            Route::get('/income/data', 'Business\Planning\IncomeController@data')->name('data.index.income.budget.plans_management');
            Route::put('/income/update/{id}', 'Business\Planning\IncomeController@update')->name('update.edit.income.budget.plans_management');
            Route::get('/income/load_budget_summary', 'Business\Planning\IncomeController@loadBudgetSummary')->name('load_budget_summary.income.budget.plans_management');

            Route::resource('income', 'Business\Planning\IncomeController', [
                'parameters' => ['income' => 'id'],
                'names' => [
                    'index' => 'index.income.budget.plans_management',
                    'create' => 'create.income.budget.plans_management',
                    'store' => 'store.create.income.budget.plans_management',
                    'show' => 'show.income.budget.plans_management',
                    'edit' => 'edit.income.budget.plans_management',
                    'destroy' => 'destroy.income.budget.plans_management'
                ]
            ])->except(['update']);

            // Current Expenditure
            Route::get('/current_expenditure_elements/loadstructure',
                'Business\Planning\CurrentExpenditureElementController@loadStructure')->name('loadstructure.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/create',
                'Business\Planning\CurrentExpenditureElementController@createOperationalActivity')->name('create.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::post('/current_expenditure_elements/operational_activities/store',
                'Business\Planning\CurrentExpenditureElementController@storeOperationalActivity')->name('store.create.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/{id}',
                'Business\Planning\CurrentExpenditureElementController@showOperationalActivity')->name('show.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/edit/{id}',
                'Business\Planning\CurrentExpenditureElementController@editOperationalActivity')->name('edit.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::put('/current_expenditure_elements/operational_activities/update/{id}',
                'Business\Planning\CurrentExpenditureElementController@updateOperationalActivity')->name('update.edit.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::delete('/current_expenditure_elements/operational_activities/destroy/{id}',
                'Business\Planning\CurrentExpenditureElementController@destroyOperationalActivity')->name('destroy.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/load_budget_summary',
                'Business\Planning\CurrentExpenditureElementController@loadBudgetSummary')->name('load_budget_summary.current_expenditure_elements.budget.plans_management');

            Route::resource('current_expenditure_elements', 'Business\Planning\CurrentExpenditureElementController', [
                'parameters' => ['current_expenditure_elements' => 'id'],
                'names' => [
                    'index' => 'index.current_expenditure_elements.budget.plans_management',
                    'create' => 'create.current_expenditure_elements.budget.plans_management',
                    'store' => 'store.create.current_expenditure_elements.budget.plans_management',
                    'show' => 'show.current_expenditure_elements.budget.plans_management',
                    'update' => 'update.edit.current_expenditure_elements.budget.plans_management',
                    'edit' => 'edit.current_expenditure_elements.budget.plans_management',
                    'destroy' => 'destroy.current_expenditure_elements.budget.plans_management'
                ]
            ]);

            // Budget Items (Operational Activities)
            Route::get('/current_expenditure_elements/operational_activities/{activityId}/items/index',
                'Business\Planning\BudgetItemController@index')->name('index.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/{activityId}/items/data',
                'Business\Planning\BudgetItemController@data')->name('data.index.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/{activityId}/{activityType?}/items/create',
                'Business\Planning\BudgetItemController@create')->name('create.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::post('/current_expenditure_elements/operational_activities/show/{activityId}/{activityType?}/items/store',
                'Business\Planning\BudgetItemController@store')->name('store.create.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/{id}/edit/{activityType?}',
                'Business\Planning\BudgetItemController@edit')->name('edit.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::put('/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/{activityType?}/update/',
                'Business\Planning\BudgetItemController@update')->name('update.edit.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::delete('/current_expenditure_elements/operational_activities/show/items/{id}/destroy',
                'Business\Planning\BudgetItemController@destroy')->name('destroy.items.operational_activities.current_expenditure_elements.budget.plans_management');

            // Public Purchases (Operational Activities)
            Route::get('/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/{activityType?}/purchases/index',
                'Business\Planning\PublicPurchaseController@index')->name('index.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/{activityType?}/purchases/data',
                'Business\Planning\PublicPurchaseController@data')->name('data.index.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/{activityType?}/purchases/create',
                'Business\Planning\PublicPurchaseController@create')->name('create.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::post('/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/purchases/store',
                'Business\Planning\PublicPurchaseController@store')->name('store.create.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/{purchaseId}/{activityType?}/purchases/modify',
                'Business\Planning\PublicPurchaseController@edit')->name('modify.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::put('/current_expenditure_elements/operational_activities/items/purchases/update/{purchaseId}',
                'Business\Planning\PublicPurchaseController@update')->name('update.modify.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::delete('/current_expenditure_elements/operational_activities/show/items/purchases/{purchaseId}/delete',
                'Business\Planning\PublicPurchaseController@destroy')->name('delete.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/cpc/search',
                'Business\Planning\PublicPurchaseController@cpcSearch')->name('cpc_search.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            Route::get('/current_expenditure_elements/operational_activities/show/items/cpc/searchProcedures',
                'Business\Planning\PublicPurchaseController@searchProcedures')->name('search_procedures.purchases.items.operational_activities.current_expenditure_elements.budget.plans_management');

            // Operational activities
            Route::get('/current_expenditure_elements/{subprogramId}/activities/index',
                'Business\Planning\ActivityProjectFiscalYearController@currentExpenditurePlanningIndex')->name('index.budget_planning.current_expenditure_elements.budget.plans_management');
            Route::post('/current_expenditure_elements/{subprogramId}/budget_planning/store',
                'Business\Planning\ActivityProjectFiscalYearController@storeBudgetPlanning')->name('store.budget_planning.current_expenditure_elements.budget.plans_management');

            // Review and approvals budget items
            Route::get('/budget/review/index', 'Business\Planning\BudgetReviewController@index')->name('index.budget_review.plans_management');
        }
    );

    Route::group([
        'middleware' => ['auth']
    ],
        function () {

            // Review and approvals budget items
            Route::get('/budget/review/index/data', 'Business\Planning\BudgetReviewController@data')->name('data.index.budget_review.plans_management');
            Route::put('/budget/review/index/bulk/approve', 'Business\Planning\BudgetReviewController@bulkApprove')->name('approve.index.budget_review.plans_management');
            Route::get('/budget/review/index/export', 'Business\Planning\BudgetReviewController@export')->name('export.index.budget_review.plans_management');

            Route::get('/budget/review/edit/{budgetItem}', 'Business\Planning\BudgetReviewController@edit')->name('edit.budget_review.plans_management');
            Route::put('/budget/review/update/{budgetItem}', 'Business\Planning\BudgetReviewController@update')->name('update.edit.budget_review.plans_management');


            Route::get('/plans_management/plans/replicate/{plan}/{type}', 'Business\Planning\PlanController@replicate')->name('replicate.plans.plans_management');

            Route::get('/current_expenditure_elements/replicate',
                'Business\Planning\CurrentExpenditureElementController@replicate')->name('replicate.current_expenditure_elements.budget.plans_management');
            Route::get('/current_expenditure_elements/load',
                'Business\Planning\CurrentExpenditureElementController@importModal')->name('load.import.current_expenditure_elements.budget.plans_management');
            Route::post('/current_expenditure_elements/import',
                'Business\Planning\CurrentExpenditureElementController@import')->name('import.current_expenditure_elements.budget.plans_management');
            Route::get('/current_expenditure_elements/download',
                'Business\Planning\CurrentExpenditureElementController@download')->name('download.current_expenditure_elements.budget.plans_management');

            Route::get('/income/replicate', 'Business\Planning\IncomeController@replicate')->name('replicate.index.income.budget.plans_management');
            Route::get('/income/index/load', 'Business\Planning\IncomeController@importModal')->name('import.index.income.budget.plans_management');
            Route::get('/income/index/download', 'Business\Planning\IncomeController@download')->name('download.index.income.budget.plans_management');
            Route::post('/income/index/load/import', 'Business\Planning\IncomeController@import')->name('load.import.index.income.budget.plans_management');


            Route::get('/operational_goals/replicate', 'Business\Planning\OperationalGoalsController@replicate')->name('replicate.operational_goals.plans_management');

            Route::get('/projects/budget/index/{projectFiscalYear}', 'Business\Planning\ProjectBudgetController@index')->name('index.budget.projects.plans_management');
            Route::get('/projects/budget/index/data/{projectFiscalYear}', 'Business\Planning\ProjectBudgetController@data')->name('data.index.budget.projects.plans_management');
            Route::get('/projects/budget/index/replicate/{projectFiscalYear}',
                'Business\Planning\ProjectBudgetController@replicate')->name('replicate.index.budget.projects.plans_management');
            Route::get('/projects/budget/index/import/{projectFiscalYear}',
                'Business\Planning\ProjectBudgetController@importModal')->name('import.index.budget.projects.plans_management');
            Route::post('/projects/budget/index/load/file/{projectFiscalYear}',
                'Business\Planning\ProjectBudgetController@import')->name('load.import.index.budget.projects.plans_management');
            Route::get('/projects/budget/index/download/{projectFiscalYear}',
                'Business\Planning\ProjectBudgetController@download')->name('download.index.budget.projects.plans_management');

            Route::get('/projects/budget/create/{projectFiscalYear}', 'Business\Planning\ProjectBudgetController@create')->name('create.index.budget.projects.plans_management');
            Route::post('/projects/budget/create/store', 'Business\Planning\ProjectBudgetController@store')->name('store.create.index.budget.projects.plans_management');
            Route::get('/projects/budget/edit/{budgetItem}', 'Business\Planning\ProjectBudgetController@edit')->name('edit.index.budget.projects.plans_management');
            Route::put('/projects/budget/edit/update/{budgetItemId}',
                'Business\Planning\ProjectBudgetController@update')->name('update.edit.index.budget.projects.plans_management');

            Route::get('/projects/schedule/index/replicate/{projectFiscalYear}',
                'Business\Planning\ScheduleController@replicate')->name('replicate.index.schedule.projects.plans_management');

            Route::get('/projects_repository/replicate/{id}',
                [ProjectsRepositoryController::class,'createProject'])->name('create.index.projects_repository.plans_management');
            Route::post('/projects_repository/store',
                [ProjectsRepositoryController::class,'storeProject'])->name('store.create.index.projects_repository.plans_management');
            Route::get('/projects_repository/structure/{element}',
                [ProjectsRepositoryController::class,'structureSearch'])->name('search.index.projects_repository.plans_management');

        }
    );

    /* Business */
    Route::group(
        [
            'prefix' => 'business',
            'middleware' => ['auth', 'route']
        ],
        function () {
            // Plans
            Route::get('/plans_management/plans/checktype', 'Business\Planning\PlanController@checkType')->name('checktype.create.plans.plans_management');
            Route::get('/plans_management/plans/check_start_year', 'Business\Planning\PlanController@checkStartYear')->name('check_start_year.create.plans.plans_management');
            Route::get('/plans_management/plans/create/{scope}', 'Business\Planning\PlanController@create')->name('create.plans.plans_management');
            Route::get('/plans_management/plans/edit/loadstructure/{id}', 'Business\Planning\PlanController@loadStructure')->name('loadstructure.edit.plans.plans_management');
            Route::get('/plans_management/plans/approve/loadstructure/{id}',
                'Business\Planning\PlanController@loadStructure')->name('loadstructure.approve.plans.plans_management');
            Route::post('/plans_management/plans/approve/changestatus/{id}', 'Business\Planning\PlanController@changeStatus')->name('changestatus.approve.plans.plans_management');
            Route::get('/plans_management/plans/approve/{id}', 'Business\Planning\PlanController@approve')->name('approve.plans.plans_management');
            Route::post('/plans_management/plans/destroy/{id}', 'Business\Planning\PlanController@destroy')->name('destroy.plans.plans_management');

            Route::resource('plans_management/plans', PlanController::class, [
                'parameters' => [
                    'plans' => 'id'
                ],
                'names' => [
                    'index' => 'index.plans.plans_management',
                    'store' => 'store.create.plans.plans_management',
                    'edit' => 'edit.plans.plans_management',
                    'update' => 'update.edit.plans.plans_management'
                ]
            ])->except(['create', 'destroy']);

            // Plan elements
            Route::post('/plans_management/plans/plan_elements/indicator/small/store',
                'Business\Planning\PlanElementController@storeSmallIndicator')->name('store.create.small.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/small/create',
                'Business\Planning\PlanElementController@createSmallIndicator')->name('create.small.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/small/show/{id}',
                'Business\Planning\PlanElementController@showSmallIndicator')->name('show.small.indicator.plan_elements.plans.plans_management');
            Route::put('/plans_management/plans/plan_elements/indicator/small/update/{id}',
                'Business\Planning\PlanElementController@updateSmallIndicator')->name('update.edit.small.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/small/edit/{id}',
                'Business\Planning\PlanElementController@editSmallIndicator')->name('edit.small.indicator.plan_elements.plans.plans_management');
            Route::post('/plans_management/plans/plan_elements/indicator/small/destroy/{id}',
                'Business\Planning\PlanElementController@destroyIndicator')->name('destroy.small.indicator.plan_elements.plans.plans_management');

            Route::post('/plans_management/plans/plan_elements/indicator/full/store',
                'Business\Planning\PlanElementController@storeFullIndicator')->name('store.create.full.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/full/create',
                'Business\Planning\PlanElementController@createFullIndicator')->name('create.full.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/full/show/{id}',
                'Business\Planning\PlanElementController@showFullIndicator')->name('show.full.indicator.plan_elements.plans.plans_management');
            Route::put('/plans_management/plans/plan_elements/indicator/full/update/{id}',
                'Business\Planning\PlanElementController@updateFullIndicator')->name('update.edit.full.indicator.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/indicator/full/edit/{id}',
                'Business\Planning\PlanElementController@editFullIndicator')->name('edit.full.indicator.plan_elements.plans.plans_management');
            Route::post('/plans_management/plans/plan_elements/indicator/full/destroy/{id}',
                'Business\Planning\PlanElementController@destroyIndicator')->name('destroy.full.indicator.plan_elements.plans.plans_management');

            Route::post('/plans_management/plans/plan_elements/update/{id}',
                'Business\Planning\PlanElementController@update')->name('update.edit.plan_elements.plans.plans_management');
            Route::post('/plans_management/plans/plan_elements/destroy/{id}',
                'Business\Planning\PlanElementController@destroy')->name('destroy.plan_elements.plans.plans_management');

            Route::post('/plans_management/plans/plan_elements/project/store',
                'Business\Planning\PlanElementController@storeProject')->name('store.create.project.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/project/create/loadannualbudgets',
                'Business\Planning\PlanElementController@loadAnnualBudgets')->name('loadannualbudgets.create.project.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/project/create',
                'Business\Planning\PlanElementController@createProject')->name('create.project.plan_elements.plans.plans_management');
            Route::post('/plans_management/plans/plan_elements/project/update/{id}',
                'Business\Planning\PlanElementController@updateProject')->name('update.edit.project.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/project/edit/loadannualbudgets',
                'Business\Planning\PlanElementController@loadAnnualBudgets')->name('loadannualbudgets.edit.project.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/project/edit/{id}',
                'Business\Planning\PlanElementController@editProject')->name('edit.project.plan_elements.plans.plans_management');
            Route::get('/plans_management/plans/plan_elements/project/show/{id}',
                'Business\Planning\PlanElementController@showProject')->name('show.project.plan_elements.plans.plans_management');
            Route::post('/plans_management/plans/plan_elements/project/destroy/{id}',
                'Business\Planning\PlanElementController@destroyProject')->name('destroy.project.plan_elements.plans.plans_management');

            Route::resource('plans_management/plans/plan_elements', 'Business\Planning\PlanElementController', [
                'parameters' => [
                    'plan_elements' => 'id'
                ],
                'names' => [
                    'create' => 'create.plan_elements.plans.plans_management',
                    'store' => 'store.create.plan_elements.plans.plans_management',
                    'show' => 'show.plan_elements.plans.plans_management',
                    'edit' => 'edit.plan_elements.plans.plans_management'
                ]
            ])->except(['update', 'destroy']);

            // Plan Links
            Route::get('/links/link/plan/load', [LinkController::class, 'loadLinks'])->name('load.plan.link.links.plans.plans_management');
            Route::get('/links/link/plan/showplanlinks/{id}', [LinkController::class, 'showPlanLinks'])->name('showplanlinks.plan.link.links.plans.plans_management');
            Route::get('/links/link/plan/{id}', [LinkController::class, 'linkPlan'])->name('plan.link.links.plans.plans_management');
            Route::get('/links/link/indicator', [LinkController::class, 'getIndicatorInfo'])->name('get_indicator_info.link.links.plans.plans_management');
            Route::get('/links/link/preview/loadtable', [LinkController::class, 'loadPreviewTable'])->name('loadtable.preview.link.links.plans.plans_management');
            Route::get('/links/link/preview', [LinkController::class, 'preview'])->name('preview.link.links.plans.plans_management');
            Route::post('/links/save', [LinkController::class, 'store'])->name('save.links.plans.plans_management');
            Route::delete('/links/destroy', [LinkController::class, 'destroy'])->name('destroy.links.plans.plans_management');

            Route::get('/indicator/plan_indicators_wizard/edit/{id}', [PlanIndicatorController::class, 'editWizard'])->name('edit.plan_indicators_wizard');

            //threshold
            Route::get('/threshold/edit', [ThresholdController::class, 'edit'])->name('edit.create.threshold');
            Route::put('/threshold/update', [ThresholdController::class, 'update'])->name('update.create.threshold');

            // Prioritization Templates
            Route::get('/prioritization_templates/data', [PrioritizationTemplateController::class, 'data'])->name('data.index.prioritization_templates');

            Route::resource('prioritization_templates', PrioritizationTemplateController::class, [
                'parameters' => ['prioritization_templates' => 'id'],
                'names' => [
                    'index' => 'index.prioritization_templates',
                    'create' => 'create.prioritization_templates',
                    'store' => 'store.create.prioritization_templates',
                    'show' => 'show.prioritization_templates',
                    'edit' => 'edit.prioritization_templates',
                    'update' => 'update.edit.prioritization_templates',
                    'destroy' => 'destroy.prioritization_templates'
                ]
            ]);

            // Attachments indicators
            Route::get('/indicators/download/{id}',
                [PlanIndicatorController::class, 'download'])->name('download.indicator_attachments.full.indicator.plan_elements.plans.plans_management');
            Route::delete('/indicators/deleteFile/{id}',
                [PlanIndicatorController::class, 'destroyFile'])->name('destroy.indicator_attachments.full.indicator.plan_elements.plans.plans_management');

            // Attachments
            Route::get('/attachments/download/{id}', [AttachmentsController::class, 'download'])->name('download.attachments.projects.plans_management');
            Route::resource('attachments', 'Business\Planning\AttachmentsController', [
                'parameters' => ['attachments' => 'id'],
                'names' => [
                    'create' => 'create.attachments.projects.plans_management',
                    'store' => 'store.create.attachments.projects.plans_management',
                    'destroy' => 'destroy.attachments.projects.plans_management'
                ]
            ])->except(['index', 'edit', 'update', 'show']);

            // Attachments roads
            Route::get('/attachments_roads/download/{id}', [AttachmentsController::class, 'downloadRoads'])->name('download_roads.attachments.projects.plans_management');
            Route::get('/attachments_roads/create/{id}', [AttachmentsController::class, 'createRoads'])->name('create_roads.attachments.projects.plans_management');
            Route::post('/attachments_roads/store', [AttachmentsController::class, 'storeRoads'])->name('store.create_roads.attachments.projects.plans_management');
            Route::delete('/attachments_roads/destroy', [AttachmentsController::class, 'destroyRoads'])->name('destroy_roads.attachments.projects.plans_management');

            // Budget Adjustment
            Route::get('/prioritized/data', [BudgetAdjustmentController::class, 'dataPrioritized'])->name('data.index.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/sync_proforma',
                [BudgetAdjustmentController::class, 'syncProforma'])->name('sync_proforma.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/preview_proforma',
                [BudgetAdjustmentController::class, 'previewProforma'])->name('preview_proforma.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/preview_proforma/data',
                [BudgetAdjustmentController::class, 'previewProformaData'])->name('data.preview_proforma.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/after_preview_proforma/data',
                [BudgetAdjustmentController::class, 'afterPreviewProformaData'])->name('data.after_preview_proforma.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/index', [BudgetAdjustmentController::class, 'index'])->name('index.budget_adjustment.budget.plans_management');

            // Budget Adjustment
            Route::get('/budget_adjustment/projects/{projectId}/activities/index',
                [BudgetAdjustmentController::class, 'activityIndex'])->name('list.activities.projects.budget_adjustment.budget.plans_management');
            Route::put('/budget_adjustment/edit', [BudgetAdjustmentController::class, 'edit'])->name('edit.budget_adjustment.budget.plans_management');
            Route::post('/budget_adjustment/approve', [BudgetAdjustmentController::class, 'approve'])->name('approve.budget_adjustment.budget.plans_management');
            Route::get('/budget_adjustment/after_preview_proforma',
                [BudgetAdjustmentController::class, 'afterPreviewProforma'])->name('after_preview_proforma.budget_adjustment.budget.plans_management');

            // Projects Repository
            Route::get('/projects_repository/data', [ProjectsRepositoryController::class,'data'])->name('data.index.projects_repository.plans_management');
            Route::get('/projects_repository/index', [ProjectsRepositoryController::class,'index'])->name('index.projects_repository.plans_management');
            Route::get('/projects_repository/change_status/{id}',
                [ProjectsRepositoryController::class,'changeStatus'])->name('change_status.projects_repository.plans_management');
            Route::put('/projects_repository/change_status/update/{id}',
                [ProjectsRepositoryController::class,'updateStatus'])->name('update.change_status.projects_repository.plans_management');
        }
    );

    /* Tracking */
    Route::group(
        [
            'prefix' => 'tracking',
            'middleware' => ['auth', 'route']
        ],
        function () {

            // Results
            Route::get('/project_result_pei/index', [ResultsController::class, 'indexPEI'])->name('index.project_result_pei.tracking');
            Route::get('/project_result_pei/indicator/{id}/{year}', [ResultsController::class, 'indicatorPEI'])->name('indicator.project_result_pei.tracking');
            Route::get('/project_result_pdot/index', [ResultsController::class, 'indexPDOT'])->name('index.project_result_pdot.tracking');
            Route::get('/project_result_pdot/indicator/{id}/{year}', [ResultsController::class, 'indicatorPDOT'])->name('indicator.project_result_pdot.tracking');

            // Sectoral Plans
            Route::get('/sectoral/index', 'Business\Tracking\SectoralPlansTrackingController@index')->name('index.sectoral.tracking');
            Route::get('/sectoral/data', 'Business\Tracking\SectoralPlansTrackingController@data')->name('data.index.sectoral.tracking');
            Route::get('/sectoral/indicators/{id}/{year}', 'Business\Tracking\SectoralPlansTrackingController@indicators')->name('indicators.data.index.sectoral.tracking');

            // Operational Goals
            Route::get('/operational_goals/index', 'Business\Tracking\OperationalGoalsTrackingController@index')->name('index.operational_goals.tracking');
            Route::get('/operational_goals/indicator/{id}/{year}', 'Business\Tracking\OperationalGoalsTrackingController@indicators')->name('indicator.operational_goals.tracking');

            // Project Indicators
            Route::get('/project_indicators/index', [ProjectTrackingController::class, 'projectIndicatorsIndex'])->name('index.project_indicators.tracking');
            Route::get('/project_indicators/data', [ProjectTrackingController::class, 'projectIndicatorsData'])->name('data.index.project_indicators.tracking');
            Route::get('/project_indicators/indicators/{id}/{year}',
                [ProjectTrackingController::class, 'projectIndicatorsShow'])->name('indicators.data.index.project_indicators.tracking');

            // Project Components
            Route::get('/project_components/index', [ProjectTrackingController::class, 'projectComponentsIndex'])->name('index.project_components.tracking');
            Route::get('/project_components/data', [ProjectTrackingController::class, 'projectComponentsData'])->name('data.index.project_components.tracking');
            Route::get('/project_components/components/{id}',
                [ProjectTrackingController::class, 'projectComponentsShow'])->name('components.data.index.project_components.tracking');
            Route::get('/project_indicators/components/indicators/{id}/{year}',
                [ProjectTrackingController::class, 'projectComponentIndicators'])->name('indicators.components.data.index.project_components.tracking');

            // Physical Progress
            Route::get('/project_tracking/physical/load_quarterly_progress',
                [ProjectPhysicalTrackingController::class, 'loadQuarterlyProgress'])->name('load_quarterly_progress.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/load_quarterly_progress/export',
                [ProjectPhysicalTrackingController::class, 'exportQuarterlyProgress'])->name('export.load_quarterly_progress.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/load_gantt',
                [ProjectPhysicalTrackingController::class, 'loadGantt'])->name('load_gantt.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/load_table',
                [ProjectPhysicalTrackingController::class, 'loadTable'])->name('load_table.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/export',
                [ProjectPhysicalTrackingController::class, 'export'])->name('export.physical.progress.project_tracking.execution');

            Route::put('/project_tracking/physical/update/{id}',
                [ProjectPhysicalTrackingController::class, 'update'])->name('update.edit.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/download_file/{id}',
                [ProjectPhysicalTrackingController::class, 'downloadFile'])->name('download_file.edit.physical.progress.project_tracking.execution');
            Route::delete('/project_tracking/physical/delete_file',
                [ProjectPhysicalTrackingController::class, 'destroyAttachment'])->name('delete_file.edit.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/edit/{id}',
                [ProjectPhysicalTrackingController::class, 'edit'])->name('edit.physical.progress.project_tracking.execution');
            Route::delete('/project_tracking/physical/destroy/{id}',
                [ProjectPhysicalTrackingController::class, 'destroy'])->name('destroy.physical.progress.project_tracking.execution');
            Route::post('/project_tracking/physical/approve/{id}',
                [ProjectPhysicalTrackingController::class, 'approve'])->name('approve.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/reject/observations',
                [ProjectPhysicalTrackingController::class, 'rejectObservations'])->name('observations.reject.physical.progress.project_tracking.execution');
            Route::put('/project_tracking/physical/reject',
                [ProjectPhysicalTrackingController::class, 'reject'])->name('reject.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/rejections/log',
                [ProjectPhysicalTrackingController::class, 'rejectionsLog'])->name('rejections_log.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/rejections/log/data',
                [ProjectPhysicalTrackingController::class, 'rejectionsLogData'])->name('data.rejections_log.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/index/{id}',
                [ProjectPhysicalTrackingController::class, 'index'])->name('index.physical.progress.project_tracking.execution');
            Route::get('/project_tracking/physical/view',
                [ProjectPhysicalTrackingController::class, 'view'])->name('view.physical.progress.project_tracking.execution');

            // Projects Tracking
            Route::get('/project_tracking/index', [ProjectTrackingController::class, 'index'])->name('index.project_tracking.execution');
            Route::get('/project_tracking/data', [ProjectTrackingController::class, 'data'])->name('data.index.project_tracking.execution');
            Route::get('/project_tracking/progress/{id}',
                [ProjectTrackingController::class, 'progressIndex'])->name('physical_budgetary_advancement.budget.progress.project_tracking.execution');

            // Projects Budget Tracking
            Route::get('/project_tracking/progress/budget/{id}', [BudgetProjectTrackingController::class, 'index'])->name('budget.progress.project_tracking.execution');
            Route::get('/project_tracking/progress/budget/{id}/data',
                [BudgetProjectTrackingController::class, 'data'])->name('data.budget.progress.project_tracking.execution');
            Route::get('/project_tracking/progress/budget/{id}/export',
                [BudgetProjectTrackingController::class, 'dataExport'])->name('export.budget.progress.project_tracking.execution');

            Route::get('/poa_tracking_physical_and_budget/index', 'Business\Tracking\POATrackingController@index')->name('index.poa_tracking_physical_and_budget.reports');
            Route::get('/poa_tracking_physical_and_budget/index/data', 'Business\Tracking\POATrackingController@data')->name('data.index.poa_tracking_physical_and_budget.reports');

            //Admin Activities
            Route::get('/admin_activities/index', [AdminActivityController::class, 'index'])->name('index.admin_activities.execution');
            Route::get('/admin_activities/index/data', [AdminActivityController::class, 'data'])->name('data.index.admin_activities.execution');
            Route::get('/admin_activities/create', [AdminActivityController::class, 'create'])->name('create.admin_activities.execution');
            Route::post('/admin_activities/create/store', [AdminActivityController::class, 'store'])->name('store.create.admin_activities.execution');

            Route::get('/admin_activities/edit/{id}', [AdminActivityController::class, 'edit'])->name('edit.admin_activities.execution');
            Route::put('/admin_activities/edit/update', [AdminActivityController::class, 'update'])->name('update.edit.admin_activities.execution');
            Route::post('/admin_activities/edit/update/{id}/upload', [AdminActivityController::class, 'upload'])->name('upload.edit.admin_activities.execution');
            Route::get('/admin_activities/edit/file/{id}/download', [AdminActivityController::class, 'download'])->name('download.edit.admin_activities.execution');
            Route::get('/admin_activities/edit/{idActivity}/file/{id}/delete',
                [AdminActivityController::class, 'deleteFile'])->name('delete.edit.admin_activities.execution');
            Route::post('/admin_activities/edit/{idActivity}/comment', [AdminActivityController::class, 'storeComment'])->name('comment.edit.admin_activities.execution');
            Route::delete('/admin_activities/delete/{adminActivity}', [AdminActivityController::class, 'delete'])->name('delete.admin_activities.execution');

            //Data Charts
            Route::get('/admin_activities/graphic/chart_1', [AdminActivityController::class, 'chart_1'])->name('chart_1.graphic.admin_activities.execution');
            Route::get('/admin_activities/graphic/chart_2', [AdminActivityController::class, 'chart_2'])->name('chart_2.graphic.admin_activities.execution');
            Route::get('/admin_activities/graphic/chart_3', [AdminActivityController::class, 'chart_3'])->name('chart_3.graphic.admin_activities.execution');

            //Calendar
            Route::get('/admin_activities/calendar/activities', [AdminActivityController::class, 'calendar'])->name('calendar.admin_activities.execution');

            // Projects certifications
            Route::get('/project/certifications/index/{id}', [CertificationController::class, 'projectIndex'])->name('index.projects.certifications.execution');
            Route::get('/project/certifications/index-data', [CertificationController::class, 'data'])->name('data.index.projects.certifications.execution');
            Route::get('/project/certifications/create/{projectId}', [CertificationController::class, 'create'])->name('create.projects.certifications.execution');
            Route::post('/project/certifications/create/store/{id}', [CertificationController::class, 'store'])->name('store.create.projects.certifications.execution');
            Route::post('/project/certifications/comment/store/{id}', [CertificationController::class, 'storeComment'])->name('comment.projects.certifications.execution');
            Route::get('/project/certifications/edit/{id}', [CertificationController::class, 'edit'])->name('edit.projects.certifications.execution');
            Route::put('/project/certifications/edit/{id}', [CertificationController::class, 'update'])->name('update.edit.projects.certifications.execution');
            Route::get('/project/certifications/items/{activityId}/{id?}', [CertificationController::class, 'items'])->name('items.projects.certifications.execution');
            Route::get('/project/certifications/show/{id}', [CertificationController::class, 'showInProject'])->name('show.projects.certifications.execution');

            // Certifications
            Route::get('/certifications/index', [CertificationController::class, 'index'])->name('index.certifications.execution');
            Route::get('/certifications/index-approved', [CertificationController::class, 'indexApproved'])->name('approved.certifications.execution');
            Route::get('/certifications/show/{id}', [CertificationController::class, 'show'])->name('show.certifications.execution');
            Route::get('/certifications/showPoa/{id}', [CertificationController::class, 'showPoa'])->name('show_poa.certifications.execution');
            Route::put('/certifications/status/{id}', [CertificationController::class, 'status'])->name('status.certifications.execution');
            Route::get('/certifications/index-data', [CertificationController::class, 'data'])->name('data.index.certifications.execution');
            Route::get('/certifications/pdf/{id}', [CertificationController::class, 'generatePdf'])->name('pdf.certifications.execution');

        }
    );

//    Route::get('/reforms/create/search/{code}', [ReformController::class,'index']search')->name('search.create.reforms.reforms_reprogramming.execution');


    /* Execution */
    Route::group(
        [
            'prefix' => 'execution',
            'middleware' => ['auth', 'route']
        ],
        function () {

            // Indicators Progress

            Route::get('/indicator_progress/download/{id}', [PlanIndicatorController::class, 'download'])->name('download.indicator_progress.execution');

            Route::get('/indicator_progress/operational_goals', [IndicatorProgressController::class, 'operationalGoals'])->name('operational_goals.indicator_progress.execution');
            Route::get('/indicator_progress/operational_goals/data', [IndicatorProgressController::class, 'operationalGoalsData'])->name('data.operational_goals.indicator_progress.execution');

            Route::get('/indicator_progress/pdot', [IndicatorProgressController::class, 'pdot'])->name('pdot.indicator_progress.execution');
            Route::get('/indicator_progress/pdot/data', [IndicatorProgressController::class, 'planData'])->name('data.pdot.indicator_progress.execution');

            Route::get('/indicator_progress/pei', [IndicatorProgressController::class, 'pei'])->name('pei.indicator_progress.execution');
            Route::get('/indicator_progress/pei/data', [IndicatorProgressController::class, 'planData'])->name('data.pei.indicator_progress.execution');

            Route::get('/indicator_progress/projects', [IndicatorProgressController::class, 'projects'])->name('projects.indicator_progress.execution');
            Route::get('/indicator_progress/projects/data', [IndicatorProgressController::class, 'projectsData'])->name('data.projects.indicator_progress.execution');

            Route::get('/indicator_progress/components', [IndicatorProgressController::class, 'components'])->name('components.indicator_progress.execution');
            Route::get('/indicator_progress/components/data',
                [IndicatorProgressController::class, 'componentsData'])->name('data.components.indicator_progress.execution');

            Route::get('/indicator_progress/sectoral', [IndicatorProgressController::class, 'sectoral'])->name('sectoral.indicator_progress.execution');
            Route::get('/indicator_progress/sectoral/data', [IndicatorProgressController::class, 'planData'])->name('data.sectoral.indicator_progress.execution');
            Route::get('/indicator_progress/sectoral/get_years/{id}',
                [IndicatorProgressController::class, 'sectoralGetYears'])->name('get_years.sectoral.indicator_progress.execution');

            Route::post('/indicator_progress/update', [IndicatorProgressController::class, 'updateIndicator'])->name('update.indicator_progress.execution');
            Route::get('/indicator_progress/show/{id}/{indicatorType}', [IndicatorProgressController::class, 'showIndicator'])->name('show.indicator_progress.execution');

            // Reforms
            Route::get('/reforms/index', [ReformController::class, 'index'])->name('index.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/data', [ReformController::class, 'data'])->name('data.index.reforms.reforms_reprogramming.execution');

            Route::get('/reforms/create', [ReformController::class, 'create'])->name('create.reforms.reforms_reprogramming.execution');
            Route::post('/reforms/create/update', [ReformController::class, 'update'])->name('update.create.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/create/projects/{executingUnitId}',
                [ReformController::class, 'loadProjects'])->name('projects.create.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/create/activities/{projectId}',
                [ReformController::class, 'loadActivities'])->name('activities.create.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/create/data', [ReformController::class, 'dataBudgetItems'])->name('data.create.reforms.reforms_reprogramming.execution');

            Route::get('/reforms/edit/{companyCode}/{year}/{operationType}/{operationNumber}',
                [ReformController::class, 'edit'])->name('edit.reforms.reforms_reprogramming.execution');

            Route::get('/reforms/show/{companyCode}/{year}/{operationType}/{operationNumber}',
                [ReformController::class, 'show'])->name('show.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/download/{name}', [ReformController::class, 'download'])->name('download.show.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/disapprove/{companyCode}/{year}/{operationType}/{operationNumber}',
                [ReformController::class, 'disapprove'])->name('disapprove.show.reforms.reforms_reprogramming.execution');
            Route::post('/reforms/approve/{companyCode}/{year}/{operationType}/{operationNumber}',
                [ReformController::class, 'approve'])->name('approve.show.reforms.reforms_reprogramming.execution');

            // Projects
            Route::get('/reforms/projects/index', 'Business\Execution\Reform\ProjectExecutionController@index')->name('index.budgetary.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/projects/data', 'Business\Execution\Reform\ProjectExecutionController@data')->name('data.index.budgetary.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/projects/edit/{id}', 'Business\Execution\Reform\ProjectExecutionController@edit')->name('edit.budgetary.reforms.reforms_reprogramming.execution');

            // Project Schedule Reforms
            Route::get('/reforms/schedule/index/loadgantt',
                'Business\Execution\ScheduleBudgetaryReprogrammingController@loadGantt')->name('load_gantt.index.schedule.budgetary.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/schedule/index/loadtable',
                'Business\Execution\ScheduleBudgetaryReprogrammingController@loadTable')->name('load_table.index.schedule.budgetary.reforms.reforms_reprogramming.execution');
            Route::put('/reforms/schedule/update',
                'Business\Execution\ScheduleBudgetaryReprogrammingController@update')->name('update.schedule.budgetary.reforms.reforms_reprogramming.execution');
            Route::post('/reforms/schedule/store',
                'Business\Execution\ScheduleBudgetaryReprogrammingController@store')->name('store.schedule.budgetary.reforms.reforms_reprogramming.execution');
            Route::delete('/reforms/schedule/destroy/{id}',
                'Business\Execution\ScheduleBudgetaryReprogrammingController@destroy')->name('destroy.schedule.budgetary.reforms.reforms_reprogramming.execution');

            // Budget Plannings Reform
            Route::post('/reforms/budget_planning/{projectId}',
                'Business\Execution\Reform\ProjectExecutionController@updateBudgetPlannings')->name('update.budgetary.reforms.reforms_reprogramming.execution');

            // Project Profile Reform
            Route::put('/reforms/profile/update/{id}',
                'Business\Execution\Reform\ProjectExecutionController@updateProjectProfile')->name('update.edit.profile.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/profile/users/executing_unit/{departmentId}',
                'Business\Execution\Reform\ProjectExecutionController@loadUsers')->name('loadusers.edit.profile.reforms.reforms_reprogramming.execution');

            // Project Logic Frame Reform
            Route::put('/reforms/logic_frame/update/{id}',
                'Business\Execution\Reform\ProjectExecutionController@updateProjectProfile')->name('update.modify.logic_frame.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/logic_frame/component/edit/{componentId}',
                'Business\Execution\Reform\ProjectExecutionController@editComponent')->name('edit.components.logic_frame.reforms.reforms_reprogramming.execution');
            Route::post('/reforms/logic_frame/component/update/edit/{componentId}',
                'Business\Execution\Reform\ProjectExecutionController@updateComponent')->name('update.edit.components.logic_frame.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/logic_frame/component/show/{id}',
                'Business\Execution\Reform\ProjectExecutionController@showComponent')->name('show.components.logic_frame.reforms.reforms_reprogramming.execution');

            Route::get('/reforms/logic_frame/component/indicator/show/{indicatorId}',
                'Business\Execution\Reform\ProjectExecutionController@showIndicator')->name('show.indicator.components.logic_frame.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/logic_frame/indicators/edit/{projectId}',
                'Business\Execution\Reform\ProjectExecutionController@editFullIndicator')->name('edit.full_indicator.logic_frame.reforms.reforms_reprogramming.execution');
            Route::put('/reforms/logic_frame/indicators/update/{indicatorId}',
                'Business\Execution\Reform\ProjectExecutionController@updateFullIndicator')->name('update.edit.full_indicator.logic_frame.reforms.reforms_reprogramming.execution');
            Route::get('/reforms/logic_frame/indicators/show/{indicatorId}',
                'Business\Execution\Reform\ProjectExecutionController@showFullIndicator')->name('show.full_indicator.logic_frame.reforms.reforms_reprogramming.execution');

            Route::get('/reforms/logic_frame/component/indicators/edit/{indicatorId}',
                'Business\Execution\Reform\ProjectExecutionController@editComponentIndicator')->name('edit.indicator.components.logic_frame.reforms.reforms_reprogramming.execution');
            Route::put('/reforms/logic_frame/component/indicators/update/{indicatorId}',
                'Business\Execution\Reform\ProjectExecutionController@updateComponentIndicator')->name('update.edit.indicator.components.logic_frame.reforms.reforms_reprogramming.execution');

            // Reprogramming
            Route::get('/reprogramming/index', [ReprogrammingController::class, 'index'])->name('index.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/index/data', [ReprogrammingController::class, 'data'])->name('data.index.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/create', [ReprogrammingController::class, 'create'])->name('create.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/create/store', [ReprogrammingController::class, 'store'])->name('store.create.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/edit/{id}', [ReprogrammingController::class, 'edit'])->name('edit.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/show/{id}', [ReprogrammingController::class, 'show'])->name('show.reprogramming.reforms_reprogramming.execution');
            Route::put('/reprogramming/edit/update/{id}', [ReprogrammingController::class, 'update'])->name('update.edit.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/download/{id}', [ReprogrammingController::class, 'download'])->name('download.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/status/{id}', [ReprogrammingController::class, 'status'])->name('status.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/{id}/project/{projectFiscalYearId}/index',
                [ReprogrammingController::class, 'projectIndex'])->name('project.reprogramming.reforms_reprogramming.execution');

            // Project Schedule Reprogramming
            Route::get('/reprogramming/schedule/index/loadgantt',
                'Business\Execution\SchedulePhysicalReprogrammingController@loadGantt')->name('load_gantt.index.schedule.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/schedule/index/loadtable',
                'Business\Execution\SchedulePhysicalReprogrammingController@loadTable')->name('load_table.index.schedule.project.reprogramming.reforms_reprogramming.execution');
            Route::put('/reprogramming/schedule/update',
                'Business\Execution\SchedulePhysicalReprogrammingController@update')->name('update.schedule.project.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/schedule/store',
                'Business\Execution\SchedulePhysicalReprogrammingController@store')->name('store.schedule.project.reprogramming.reforms_reprogramming.execution');
            Route::delete('/reprogramming/schedule/destroy/{id}',
                'Business\Execution\SchedulePhysicalReprogrammingController@destroy')->name('destroy.schedule.project.reprogramming.reforms_reprogramming.execution');
            Route::put('/reprogramming/schedule/project/dates',
                'Business\Execution\SchedulePhysicalReprogrammingController@updateProjectDates')->name('update_dates.schedule.project.reprogramming.reforms_reprogramming.execution');

            // Budget Plannings Reprogramming
            Route::post('/reprogramming/budget_planning/{projectId}',
                [ProjectReprogrammingController::class, 'updateBudgetPlannings'])->name('update.budgetary.project.reprogramming.reforms_reprogramming.execution');

            // Project Profile Reprogramming
            Route::put('/reprogramming/profile/update/{id}',
                [ProjectReprogrammingController::class, 'updateProjectProfile'])->name('update.edit.profile.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/profile/users/executing_unit/{departmentId}',
                [ProjectReprogrammingController::class, 'loadUsers'])->name('loadusers.edit.profile.project.reprogramming.reforms_reprogramming.execution');

            // Project Logic Frame Reprogramming
            Route::put('/reprogramming/logic_frame/update/{id}',
                [ProjectReprogrammingController::class, 'updateProjectProfile'])->name('update.modify.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/create/{projectId}',
                [ProjectReprogrammingController::class, 'createComponent'])->name('create.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/logic_frame/components/create/store/{projectId}',
                [ProjectReprogrammingController::class, 'storeComponent'])->name('store.create.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/edit/{projectId}',
                [ProjectReprogrammingController::class, 'editComponent'])->name('edit.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/logic_frame/components/update/edit/{componentId}',
                [ProjectReprogrammingController::class, 'updateComponent'])->name('update.edit.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/show/{id}',
                [ProjectReprogrammingController::class, 'showComponent'])->name('show.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/destroy/{componentId}',
                [ProjectReprogrammingController::class, 'destroyComponent'])->name('destroy.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');


            Route::get('/reprogramming/logic_frame/indicators/create/{projectId}',
                [ProjectReprogrammingController::class, 'createFullIndicator'])->name('create.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/logic_frame/indicators/store',
                [ProjectReprogrammingController::class, 'storeFullIndicator'])->name('store.create.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/indicators/edit/{projectId}',
                [ProjectReprogrammingController::class, 'editFullIndicator'])->name('edit.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::put('/reprogramming/logic_frame/indicators/update/{indicatorId}',
                [ProjectReprogrammingController::class, 'updateFullIndicator'])->name('update.edit.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/indicators/show/{indicatorId}',
                [ProjectReprogrammingController::class, 'showFullIndicator'])->name('show.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/indicators/delete/{indicatorId}',
                [ProjectReprogrammingController::class, 'deleteFullIndicator'])->name('delete.full_indicator.logic_frame.project.reprogramming.reforms_reprogramming.execution');

            Route::get('/reprogramming/logic_frame/components/indicator/build/{componentId}',
                [ProjectReprogrammingController::class, 'createComponentIndicator'])->name('build.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::post('/reprogramming/logic_frame/components/indicator/store/',
                [ProjectReprogrammingController::class, 'storeComponentIndicator'])->name('store.build.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');

            Route::get('/reprogramming/logic_frame/components/indicator/show/{indicatorId}',
                [ProjectReprogrammingController::class, 'showIndicator'])->name('show.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/indicators/edit/{indicatorId}',
                [ProjectReprogrammingController::class, 'editComponentIndicator'])->name('edit.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::put('/reprogramming/logic_frame/components/indicators/update/{indicatorId}',
                [ProjectReprogrammingController::class, 'updateComponentIndicator'])->name('update.edit.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');
            Route::get('/reprogramming/logic_frame/components/indicators/delete/{indicatorId}',
                [ProjectReprogrammingController::class, 'deleteComponentIndicator'])->name('delete.indicator.components.logic_frame.project.reprogramming.reforms_reprogramming.execution');

            // Programmatic Structure
            // Incomes
            Route::get('/programmatic_structure/income/data',
                [IncomeController::class, 'data'])->name('data.index.income.programmatic_structure.execution');

            Route::resource('/programmatic_structure/income', IncomeController::class, [
                'parameters' => ['income' => 'id'],
                'names' => [
                    'index' => 'index.income.programmatic_structure.execution',
                    'create' => 'create.income.programmatic_structure.execution',
                    'store' => 'store.create.income.programmatic_structure.execution',
                    'show' => 'show.income.programmatic_structure.execution',
                    'edit' => 'edit.income.programmatic_structure.execution',
                    'update' => 'update.edit.income.programmatic_structure.execution',
                    'destroy' => 'destroy.income.programmatic_structure.execution'
                ]
            ])->middleware('programmatic.structure');

            // Projects
            Route::get('/programmatic_structure/project/data',
                [ProjectController::class, 'data'])->name('data.index.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/project',
                [ProjectController::class, 'index'])->name('index.project.programmatic_structure.execution')->middleware('programmatic.structure');
            Route::get('/programmatic_structure/project/structure/{id}',
                [ProjectController::class, 'structure'])->name('structure.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/project/{id}/check_status',
                [ProjectController::class, 'checkProjectStatus'])->name('check_status.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/project/{id}/reset_budget_items',
                [ProjectController::class, 'resetBudgetItems'])->name('reset_budget_items.project.programmatic_structure.execution');
            Route::post('/programmatic_structure/project/{id}/start',
                [ProjectController::class, 'start'])->name('start.project.programmatic_structure.execution');

            // Profile
            Route::get('/programmatic_structure/project/profile/{id}',
                [ProjectController::class, 'profile'])->name('profile.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/project/profile/update/{id}',
                [ProjectController::class, 'updateProjectProfile'])->name('update.profile.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/profile/users/executing_unit/{departmentId}',
                [ProjectController::class, 'loadUsers'])->name('loadusers.profile.project.programmatic_structure.execution');

            // Logic Frame
            Route::get('/programmatic_structure/projects/logic_frame/{id}',
                [ProjectController::class, 'logicFrame'])->name('logic_frame.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/projects/logic_frame/update/{id}',
                [ProjectController::class, 'updateLogicFrame'])->name('update.logic_frame.project.programmatic_structure.execution');

            Route::post('/programmatic_structure/projects/logic_frame/components/update/{id}',
                [ProjectController::class, 'updateComponent'])->name('update.edit.components.logic_frame.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/logic_frame/components/edit/{id}',
                [ProjectController::class, 'editComponent'])->name('edit.components.logic_frame.project.programmatic_structure.execution');
            Route::post('/programmatic_structure/projects/logic_frame/components/create/store/{projectId}',
                [ProjectController::class, 'storeComponent'])->name('store.create.components.logic_frame.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/logic_frame/components/create/{projectId}',
                [ProjectController::class, 'createComponent'])->name('create.components.logic_frame.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/logic_frame/components/show/{componentId}',
                [ProjectController::class, 'showComponent'])->name('show.components.logic_frame.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/logic_frame/components/destroy/{componentId}',
                [ProjectController::class, 'destroyComponent'])->name('destroy.components.logic_frame.project.programmatic_structure.execution');

            // Project Activities
            Route::get('/programmatic_structure/projects/{projectId}/activities/create',
                [ActivityProjectFiscalYearController::class, 'create'])->name('create.activities.project.programmatic_structure.execution');
            Route::post('/programmatic_structure/projects/activities/create/store',
                [ActivityProjectFiscalYearController::class, 'store'])->name('store.create.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/activities/edit/{id}',
                [ActivityProjectFiscalYearController::class, 'edit'])->name('edit.activities.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/projects/activities/update/{id}',
                [ActivityProjectFiscalYearController::class, 'update'])->name('update.edit.activities.project.programmatic_structure.execution');
            Route::delete('/programmatic_structure/projects/activities/destroy/{id}',
                [ActivityProjectFiscalYearController::class, 'destroy'])->name('destroy.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/{id}/activities/index',
                [ActivityProjectFiscalYearController::class, 'index'])->name('index.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/{projectId}/activities/data',
                [ActivityProjectFiscalYearController::class, 'data'])->name('data.index.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/activities/budget_items/{activityId}',
                [ActivityProjectFiscalYearController::class, 'budgetItems'])->name('budget_items.activities.project.programmatic_structure.execution');

            // Budget Items
            Route::get('/programmatic_structure/projects/budget_items/{activityId}/items/data',
                [BudgetItemController::class, 'data'])->name('data.index.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/budget_items/{activityId}/items/create',
                [BudgetItemController::class, 'create'])->name('create.items.activities.project.programmatic_structure.execution');
            Route::post('/programmatic_structure/projects/budget_items/{activityId}/items/store',
                [BudgetItemController::class, 'store'])->name('store.create.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/budget_items/items/{id}/edit/',
                [BudgetItemController::class, 'edit'])->name('edit.items.activities.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/projects/budget_items/items/{budgetItemId}/update',
                [BudgetItemController::class, 'update'])->name('update.edit.items.activities.project.programmatic_structure.execution');
            Route::delete('/programmatic_structure/projects/budget_items/items/{id}/destroy',
                [BudgetItemController::class, 'destroy'])->name('destroy.items.activities.project.programmatic_structure.execution');

            // Public Purchases
            Route::get('/programmatic_structure/projects/public_purchases/items/{id}/purchases/index/{activityType?}',
                [PublicPurchaseController::class, 'index'])->name('index.purchases.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/public_purchases/items/{budgetItemId}/purchases/data/{activityType?}',
                [PublicPurchaseController::class, 'data'])->name('data.index.purchases.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/public_purchases/items/{budgetItemId}/purchases/create/{activityType?}',
                [PublicPurchaseController::class, 'create'])->name('create.purchases.items.activities.project.programmatic_structure.execution');
            Route::post('/programmatic_structure/projects/public_purchases/items/{budgetItemId}/purchases/store',
                [PublicPurchaseController::class, 'store'])->name('store.create.purchases.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/public_purchases/items/{id}/purchases/modify/{activityType?}',
                [PublicPurchaseController::class, 'edit'])->name('modify.purchases.items.activities.project.programmatic_structure.execution');
            Route::put('/programmatic_structure/projects/public_purchases/items/{purchaseId}/purchases/update',
                [PublicPurchaseController::class, 'update'])->name('update.modify.purchases.items.activities.project.programmatic_structure.execution');
            Route::delete('/programmatic_structure/projects/public_purchases/items/purchases/{id}/delete',
                [PublicPurchaseController::class, 'destroy'])->name('delete.purchases.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/activities/show/items/cpc/search',
                [PublicPurchaseController::class, 'cpcSearch'])->name('cpc_search.purchases.items.activities.project.programmatic_structure.execution');
            Route::get('/programmatic_structure/projects/activities/show/items/cpc/searchProcedures',
                [PublicPurchaseController::class, 'searchProcedures'])->name('search_procedures.purchases.items.activities.project.programmatic_structure.execution');

            // Current Expenditure
            Route::get('/programmatic_structure/current_expenditure_elements/loadstructure',
                [CurrentExpenditureElementController::class, 'loadStructure'])->name('loadstructure.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/create',
                [CurrentExpenditureElementController::class, 'createOperationalActivity'])->name('create.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::post('/programmatic_structure/current_expenditure_elements/operational_activities/store',
                [CurrentExpenditureElementController::class, 'storeOperationalActivity'])->name('store.create.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/{id}',
                [CurrentExpenditureElementController::class, 'showOperationalActivity'])->name('show.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/edit/{id}',
                [CurrentExpenditureElementController::class, 'editOperationalActivity'])->name('edit.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::put('/programmatic_structure/current_expenditure_elements/operational_activities/update/{id}',
                [CurrentExpenditureElementController::class, 'updateOperationalActivity'])->name('update.edit.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::delete('/programmatic_structure/current_expenditure_elements/operational_activities/destroy/{id}',
                [CurrentExpenditureElementController::class, 'destroyOperationalActivity'])->name('destroy.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::resource('/programmatic_structure/current_expenditure_elements', CurrentExpenditureElementController::class, [
                'parameters' => ['current_expenditure_elements' => 'id'],
                'names' => [
                    'index' => 'index.current_expenditure_elements.programmatic_structure.execution',
                    'create' => 'create.current_expenditure_elements.programmatic_structure.execution',
                    'store' => 'store.create.current_expenditure_elements.programmatic_structure.execution',
                    'show' => 'show.current_expenditure_elements.programmatic_structure.execution',
                    'update' => 'update.edit.current_expenditure_elements.programmatic_structure.execution',
                    'edit' => 'edit.current_expenditure_elements.programmatic_structure.execution',
                    'destroy' => 'destroy.current_expenditure_elements.programmatic_structure.execution'
                ]
            ])->middleware('programmatic.structure');

            // Budget Items (Operational Activities)
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/budget_items/{activityId}/items/data',
                [BudgetItemController::class, 'data'])->name('data.index.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/{activityId}/items/index',
                [BudgetItemController::class, 'index'])->name('index.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/{activityId}/{activityType?}/items/create',
                [BudgetItemController::class, 'create'])->name('create.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::post('/programmatic_structure/current_expenditure_elements/operational_activities/show/{activityId}/{activityType?}/items/store',
                [BudgetItemController::class, 'store'])->name('store.create.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/{id}/edit/{activityType?}',
                [BudgetItemController::class, 'edit'])->name('edit.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::put('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/{budgetItemId}/{activityType?}/update/',
                [BudgetItemController::class, 'update'])->name('update.edit.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');
            Route::delete('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/{id}/destroy',
                [BudgetItemController::class, 'destroy'])->name('destroy.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            // Public Purchases (Operational Activities)
            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/{id}/{activityType?}/purchases/index',
                [PublicPurchaseController::class, 'index'])->name('index.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/items/{budgetItemId}/{activityType?}/purchases/data',
                [PublicPurchaseController::class, 'data'])->name('data.index.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/public_purchases/items/{budgetItemId}/{activityType?}/purchases/create',
                [PublicPurchaseController::class, 'create'])->name('create.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::post('/programmatic_structure/current_expenditure_elements/operational_activities/public_purchases/items/{budgetItemId}/purchases/store',
                [PublicPurchaseController::class, 'store'])->name('store.create.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/public_purchases/items/{id}/{activityType?}/purchases/modify',
                [PublicPurchaseController::class, 'edit'])->name('modify.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::put('/programmatic_structure/current_expenditure_elements/operational_activities/public_purchases/items/{purchaseId}/purchases/update',
                [PublicPurchaseController::class, 'update'])->name('update.modify.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::delete('/programmatic_structure/current_expenditure_elements/operational_activities/public_purchases/items/purchases/{id}/delete',
                [PublicPurchaseController::class, 'destroy'])->name('delete.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/cpc/search',
                [PublicPurchaseController::class, 'cpcSearch'])->name('cpc_search.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

            Route::get('/programmatic_structure/current_expenditure_elements/operational_activities/show/items/cpc/searchProcedures',
                [PublicPurchaseController::class, 'searchProcedures'])->name('search_procedures.purchases.items.operational_activities.current_expenditure_elements.programmatic_structure.execution');

        }
    );/* ------------- */

    Route::group(
        [
            'prefix' => 'execution',
            'middleware' => ['auth']
        ],
        function () {
            Route::get('/reforms/create/search/{code}', [ReformController::class, 'search'])->name('search.create.reforms.reforms_reprogramming.execution');
            Route::get('/project_tracking/progress/budget/{item}/locations', [BudgetProjectTrackingController::class, 'indexLocation'])
                ->name('index.location.budget.progress.project_tracking.execution');
            Route::post('/project_tracking/progress/budget/{item}/locations', [BudgetProjectTrackingController::class, 'storeLocation']
            )->name('store.location.budget.progress.project_tracking.execution');
        });

    /* INVENTORY ROADS */
    /* ------------- */

    /* inventory roads */
    Route::group(
        [
            'prefix' => 'inventory_roads',
            'middleware' => ['auth', 'route']
        ],
        function () {
            Route::get('roads/hdm4_roads/index', 'Business\Roads\InventoryRoad\InventoryRoadController@indexHdm4')->name('index.hdm4_roads');
            Route::post('roads/hdm4_roads/import', 'Business\Roads\InventoryRoad\InventoryRoadController@importHdm4')->name('import_file.index.hdm4_roads');
            Route::get('roads/data', 'Business\Roads\InventoryRoad\InventoryRoadController@data')->name('data.index.inventory_roads');
            Route::get('roads/shapes/{code}', 'Business\Roads\InventoryRoad\InventoryRoadController@shapes')->name('shapes.index.inventory_roads');
            Route::get('roads/check_code_create',
                'Business\Roads\InventoryRoad\InventoryRoadController@checkCodeGeneralCharacteristicsOfTrack')->name('check_code.create.inventory_roads');
            Route::get('roads/check_code_edit',
                'Business\Roads\InventoryRoad\InventoryRoadController@checkCodeGeneralCharacteristicsOfTrack')->name('check_code.edit.inventory_roads');
            Route::get('roads/edit_components/{code}', 'Business\Roads\InventoryRoad\InventoryRoadController@editComponents')->name('edit_components.inventory_roads');
            Route::post('roads/update/{code}', 'Business\Roads\InventoryRoad\InventoryRoadController@update')->name('update.edit.inventory_roads');

            Route::resource('roads', 'Business\Roads\InventoryRoad\InventoryRoadController', [
                'parameters' => ['prioritization_template' => 'codigo'],
                'names' => [
                    'index' => 'index.inventory_roads',
                    'create' => 'create.inventory_roads',
                    'store' => 'store.create.inventory_roads',
                    'show' => 'show.inventory_roads',
                    'edit' => 'edit.inventory_roads'
                ]
            ])->except(['destroy', 'update']);

            Route::get('roads/characteristics_of_track/index/{code}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@index')->name('index.characteristics_of_track.inventory_roads');
            Route::get('roads/characteristics_of_track/index_show/{code}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@indexShow')->name('index_show.characteristics_of_track.inventory_roads');
            Route::get('roads/characteristics_of_track/data/{code}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@data')->name('data.index.characteristics_of_track.inventory_roads');
            Route::get('roads/characteristics_of_track/create/{code}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@create')->name('create.characteristics_of_track.inventory_roads');

            Route::post('roads/characteristics_of_track/create/store',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@store')->name('store.create.characteristics_of_track.inventory_roads');
            Route::get('roads/characteristics_of_track/edit/{gid}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@edit')->name('edit.characteristics_of_track.inventory_roads');
            Route::post('roads/characteristics_of_track/edit/update/{gid}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@update')->name('update.edit.characteristics_of_track.inventory_roads');
            Route::get('roads/characteristics_of_track/edit/show/{gid}',
                'Business\Roads\InventoryRoad\CharacteristicsOfTrackController@show')->name('show.characteristics_of_track.inventory_roads');

            Route::get('roads/sewer/index/{code}', 'Business\Roads\InventoryRoad\SewerController@index')->name('index.sewer.inventory_roads');
            Route::get('roads/sewer/index_show/{code}', 'Business\Roads\InventoryRoad\SewerController@indexShow')->name('index_show.index.sewer.inventory_roads');
            Route::get('roads/sewer/data/{code}', 'Business\Roads\InventoryRoad\SewerController@data')->name('data.index.sewer.inventory_roads');
            Route::get('roads/sewer/create/{code}', 'Business\Roads\InventoryRoad\SewerController@create')->name('create.sewer.inventory_roads');
            Route::post('roads/sewer/create/store', 'Business\Roads\InventoryRoad\SewerController@store')->name('store.create.sewer.inventory_roads');
            Route::get('roads/sewer/edit/{gid}', 'Business\Roads\InventoryRoad\SewerController@edit')->name('edit.sewer.inventory_roads');
            Route::post('roads/sewer/edit/update/{gid}', 'Business\Roads\InventoryRoad\SewerController@update')->name('update.edit.sewer.inventory_roads');
            Route::get('roads/sewer/edit/show/{gid}', 'Business\Roads\InventoryRoad\SewerController@show')->name('show.sewer.inventory_roads');

            Route::get('roads/bridge/index/{code}', 'Business\Roads\InventoryRoad\BridgeController@index')->name('index.bridge.inventory_roads');
            Route::get('roads/bridge/index_show/{code}', 'Business\Roads\InventoryRoad\BridgeController@indexShow')->name('index_show.index.bridge.inventory_roads');
            Route::get('roads/bridge/data/{code}', 'Business\Roads\InventoryRoad\BridgeController@data')->name('data.index.bridge.inventory_roads');
            Route::get('roads/bridge/create/{code}', 'Business\Roads\InventoryRoad\BridgeController@create')->name('create.bridge.inventory_roads');
            Route::post('roads/bridge/create/store', 'Business\Roads\InventoryRoad\BridgeController@store')->name('store.create.bridge.inventory_roads');
            Route::get('roads/bridge/edit/{gid}', 'Business\Roads\InventoryRoad\BridgeController@edit')->name('edit.bridge.inventory_roads');
            Route::post('roads/bridge/edit/update/{gid}', 'Business\Roads\InventoryRoad\BridgeController@update')->name('update.edit.bridge.inventory_roads');
            Route::get('roads/bridge/edit/show/{gid}', 'Business\Roads\InventoryRoad\BridgeController@show')->name('show.bridge.inventory_roads');

            Route::get('roads/ditch/index/{code}', 'Business\Roads\InventoryRoad\DitchController@index')->name('index.ditch.inventory_roads');
            Route::get('roads/ditch/index_show/{code}', 'Business\Roads\InventoryRoad\DitchController@indexShow')->name('index_show.index.ditch.inventory_roads');
            Route::get('roads/ditch/data/{code}', 'Business\Roads\InventoryRoad\DitchController@data')->name('data.index.ditch.inventory_roads');
            Route::get('roads/ditch/create/{code}', 'Business\Roads\InventoryRoad\DitchController@create')->name('create.ditch.inventory_roads');
            Route::post('roads/ditch/create/store', 'Business\Roads\InventoryRoad\DitchController@store')->name('store.create.ditch.inventory_roads');
            Route::get('roads/ditch/edit/{gid}', 'Business\Roads\InventoryRoad\DitchController@edit')->name('edit.ditch.inventory_roads');
            Route::post('roads/ditch/edit/update/{gid}', 'Business\Roads\InventoryRoad\DitchController@update')->name('update.edit.ditch.inventory_roads');
            Route::get('roads/ditch/edit/show/{gid}', 'Business\Roads\InventoryRoad\DitchController@show')->name('show.ditch.inventory_roads');

            Route::get('roads/slope/index/{code}', 'Business\Roads\InventoryRoad\SlopeController@index')->name('index.slope.inventory_roads');
            Route::get('roads/slope/index_show/{code}', 'Business\Roads\InventoryRoad\SlopeController@indexShow')->name('index_show.index.slope.inventory_roads');
            Route::get('roads/slope/data/{code}', 'Business\Roads\InventoryRoad\SlopeController@data')->name('data.index.slope.inventory_roads');
            Route::get('roads/slope/create/{code}', 'Business\Roads\InventoryRoad\SlopeController@create')->name('create.slope.inventory_roads');
            Route::post('roads/slope/create/store', 'Business\Roads\InventoryRoad\SlopeController@store')->name('store.create.slope.inventory_roads');
            Route::get('roads/slope/edit/{gid}', 'Business\Roads\InventoryRoad\SlopeController@edit')->name('edit.slope.inventory_roads');
            Route::post('roads/slope/edit/update/{gid}', 'Business\Roads\InventoryRoad\SlopeController@update')->name('update.edit.slope.inventory_roads');
            Route::get('roads/slope/edit/show/{gid}', 'Business\Roads\InventoryRoad\SlopeController@show')->name('show.slope.inventory_roads');

            Route::get('roads/signal_horizontal/index/{code}', 'Business\Roads\InventoryRoad\SignalHorizontalController@index')->name('index.signal_horizontal.inventory_roads');
            Route::get('roads/signal_horizontal/index_show/{code}',
                'Business\Roads\InventoryRoad\SignalHorizontalController@indexShow')->name('index_show.index.signal_horizontal.inventory_roads');
            Route::get('roads/signal_horizontal/data/{code}', 'Business\Roads\InventoryRoad\SignalHorizontalController@data')->name('data.index.signal_horizontal.inventory_roads');
            Route::get('roads/signal_horizontal/create/{code}', 'Business\Roads\InventoryRoad\SignalHorizontalController@create')->name('create.signal_horizontal.inventory_roads');
            Route::post('roads/signal_horizontal/create/store',
                'Business\Roads\InventoryRoad\SignalHorizontalController@store')->name('store.create.signal_horizontal.inventory_roads');
            Route::get('roads/signal_horizontal/edit/{gid}', 'Business\Roads\InventoryRoad\SignalHorizontalController@edit')->name('edit.signal_horizontal.inventory_roads');
            Route::post('roads/signal_horizontal/edit/update/{gid}',
                'Business\Roads\InventoryRoad\SignalHorizontalController@update')->name('update.edit.signal_horizontal.inventory_roads');
            Route::get('roads/signal_horizontal/edit/show/{gid}', 'Business\Roads\InventoryRoad\SignalHorizontalController@show')->name('show.signal_horizontal.inventory_roads');

            Route::get('roads/signal_vertical/index/{code}', 'Business\Roads\InventoryRoad\SignalVerticalController@index')->name('index.signal_vertical.inventory_roads');
            Route::get('roads/signal_vertical/index_show/{code}',
                'Business\Roads\InventoryRoad\SignalVerticalController@indexShow')->name('index_show.index.signal_vertical.inventory_roads');
            Route::get('roads/signal_vertical/data/{code}', 'Business\Roads\InventoryRoad\SignalVerticalController@data')->name('data.index.signal_vertical.inventory_roads');
            Route::get('roads/signal_vertical/create/{code}', 'Business\Roads\InventoryRoad\SignalVerticalController@create')->name('create.signal_vertical.inventory_roads');
            Route::post('roads/signal_vertical/create/store', 'Business\Roads\InventoryRoad\SignalVerticalController@store')->name('store.create.signal_vertical.inventory_roads');
            Route::get('roads/signal_vertical/edit/{gid}', 'Business\Roads\InventoryRoad\SignalVerticalController@edit')->name('edit.signal_vertical.inventory_roads');
            Route::post('roads/signal_vertical/edit/update/{gid}',
                'Business\Roads\InventoryRoad\SignalVerticalController@update')->name('update.edit.signal_vertical.inventory_roads');
            Route::get('roads/signal_vertical/edit/show/{gid}', 'Business\Roads\InventoryRoad\SignalVerticalController@show')->name('show.signal_vertical.inventory_roads');

            Route::get('roads/traffic/index/{code}', 'Business\Roads\InventoryRoad\TrafficController@index')->name('index.traffic.inventory_roads');
            Route::get('roads/traffic/index_show/{code}', 'Business\Roads\InventoryRoad\TrafficController@indexShow')->name('index_show.index.traffic.inventory_roads');
            Route::get('roads/traffic/data/{code}', 'Business\Roads\InventoryRoad\TrafficController@data')->name('data.index.traffic.inventory_roads');
            Route::get('roads/traffic/create/{code}', 'Business\Roads\InventoryRoad\TrafficController@create')->name('create.traffic.inventory_roads');
            Route::post('roads/traffic/create/store', 'Business\Roads\InventoryRoad\TrafficController@store')->name('store.create.traffic.inventory_roads');
            Route::get('roads/traffic/edit/{gid}', 'Business\Roads\InventoryRoad\TrafficController@edit')->name('edit.traffic.inventory_roads');
            Route::post('roads/traffic/edit/update/{gid}', 'Business\Roads\InventoryRoad\TrafficController@update')->name('update.edit.traffic.inventory_roads');
            Route::get('roads/traffic/edit/show/{gid}', 'Business\Roads\InventoryRoad\TrafficController@show')->name('show.traffic.inventory_roads');

            Route::get('roads/mines/index/{code}', 'Business\Roads\InventoryRoad\MinesController@index')->name('index.mines.inventory_roads');
            Route::get('roads/mines/index_show/{code}', 'Business\Roads\InventoryRoad\MinesController@indexShow')->name('index_show.index.mines.inventory_roads');
            Route::get('roads/mines/data/{code}', 'Business\Roads\InventoryRoad\MinesController@data')->name('data.index.mines.inventory_roads');
            Route::get('roads/mines/create/{code}', 'Business\Roads\InventoryRoad\MinesController@create')->name('create.mines.inventory_roads');
            Route::post('roads/mines/create/store', 'Business\Roads\InventoryRoad\MinesController@store')->name('store.create.mines.inventory_roads');
            Route::get('roads/mines/edit/{gid}', 'Business\Roads\InventoryRoad\MinesController@edit')->name('edit.mines.inventory_roads');
            Route::post('roads/mines/edit/update/{gid}', 'Business\Roads\InventoryRoad\MinesController@update')->name('update.edit.mines.inventory_roads');
            Route::get('roads/mines/edit/show/{gid}', 'Business\Roads\InventoryRoad\MinesController@show')->name('show.mines.inventory_roads');

            Route::get('roads/critical_point/index/{code}', 'Business\Roads\InventoryRoad\CriticalPointController@index')->name('index.critical_point.inventory_roads');
            Route::get('roads/critical_point/index_show/{code}',
                'Business\Roads\InventoryRoad\CriticalPointController@indexShow')->name('index_show.index.critical_point.inventory_roads');
            Route::get('roads/critical_point/data/{code}', 'Business\Roads\InventoryRoad\CriticalPointController@data')->name('data.index.critical_point.inventory_roads');
            Route::get('roads/critical_point/create/{code}', 'Business\Roads\InventoryRoad\CriticalPointController@create')->name('create.critical_point.inventory_roads');
            Route::post('roads/critical_point/create/store', 'Business\Roads\InventoryRoad\CriticalPointController@store')->name('store.create.critical_point.inventory_roads');
            Route::get('roads/critical_point/edit/{gid}', 'Business\Roads\InventoryRoad\CriticalPointController@edit')->name('edit.critical_point.inventory_roads');
            Route::post('roads/critical_point/edit/update/{gid}',
                'Business\Roads\InventoryRoad\CriticalPointController@update')->name('update.edit.critical_point.inventory_roads');
            Route::get('roads/critical_point/edit/show/{gid}', 'Business\Roads\InventoryRoad\CriticalPointController@show')->name('show.critical_point.inventory_roads');

            Route::get('roads/intersection/index/{code}', 'Business\Roads\InventoryRoad\IntersectionController@index')->name('index.intersection.inventory_roads');
            Route::get('roads/intersection/index_show/{code}',
                'Business\Roads\InventoryRoad\IntersectionController@indexShow')->name('index_show.index.intersection.inventory_roads');
            Route::get('roads/intersection/data/{code}', 'Business\Roads\InventoryRoad\IntersectionController@data')->name('data.index.intersection.inventory_roads');
            Route::get('roads/intersection/create/{code}', 'Business\Roads\InventoryRoad\IntersectionController@create')->name('create.intersection.inventory_roads');
            Route::post('roads/intersection/create/store', 'Business\Roads\InventoryRoad\IntersectionController@store')->name('store.create.intersection.inventory_roads');
            Route::get('roads/intersection/edit/{gid}', 'Business\Roads\InventoryRoad\IntersectionController@edit')->name('edit.intersection.inventory_roads');
            Route::post('roads/intersection/edit/update/{gid}', 'Business\Roads\InventoryRoad\IntersectionController@update')->name('update.edit.intersection.inventory_roads');
            Route::get('roads/intersection/edit/show/{gid}', 'Business\Roads\InventoryRoad\IntersectionController@show')->name('show.intersection.inventory_roads');

            Route::get('roads/conservation_needs/index/{code}', 'Business\Roads\InventoryRoad\ConservationNeedsController@index')->name('index.conservation_needs.inventory_roads');
            Route::get('roads/conservation_needs/index_show/{code}',
                'Business\Roads\InventoryRoad\ConservationNeedsController@indexShow')->name('index_show.index.conservation_needs.inventory_roads');
            Route::get('roads/conservation_needs/data/{code}',
                'Business\Roads\InventoryRoad\ConservationNeedsController@data')->name('data.index.conservation_needs.inventory_roads');
            Route::get('roads/conservation_needs/create/{code}',
                'Business\Roads\InventoryRoad\ConservationNeedsController@create')->name('create.conservation_needs.inventory_roads');
            Route::post('roads/conservation_needs/create/store',
                'Business\Roads\InventoryRoad\ConservationNeedsController@store')->name('store.create.conservation_needs.inventory_roads');
            Route::get('roads/conservation_needs/edit/{gid}', 'Business\Roads\InventoryRoad\ConservationNeedsController@edit')->name('edit.conservation_needs.inventory_roads');
            Route::post('roads/conservation_needs/edit/update/{gid}',
                'Business\Roads\InventoryRoad\ConservationNeedsController@update')->name('update.edit.conservation_needs.inventory_roads');
            Route::get('roads/conservation_needs/edit/show/{gid}',
                'Business\Roads\InventoryRoad\ConservationNeedsController@show')->name('show.conservation_needs.inventory_roads');

            Route::get('roads/environmental_information/index/{code}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@index')->name('index.environmental_information.inventory_roads');
            Route::get('roads/environmental_information/index_show/{code}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@indexShow')->name('index_show.index.environmental_information.inventory_roads');
            Route::get('roads/environmental_information/data/{code}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@data')->name('data.index.environmental_information.inventory_roads');
            Route::get('roads/environmental_information/create/{code}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@create')->name('create.environmental_information.inventory_roads');
            Route::post('roads/environmental_information/create/store',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@store')->name('store.create.environmental_information.inventory_roads');
            Route::get('roads/environmental_information/edit/{gid}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@edit')->name('edit.environmental_information.inventory_roads');
            Route::post('roads/environmental_information/edit/update/{gid}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@update')->name('update.edit.environmental_information.inventory_roads');
            Route::get('roads/environmental_information/edit/show/{gid}',
                'Business\Roads\InventoryRoad\EnvironmentalInformationController@show')->name('show.environmental_information.inventory_roads');

            Route::get('roads/production/index/{code}', 'Business\Roads\InventoryRoad\ProductionController@index')->name('index.production.inventory_roads');
            Route::get('roads/production/index_show/{code}', 'Business\Roads\InventoryRoad\ProductionController@indexShow')->name('index_show.index.production.inventory_roads');
            Route::get('roads/production/data/{code}', 'Business\Roads\InventoryRoad\ProductionController@data')->name('data.index.production.inventory_roads');
            Route::get('roads/production/create/{code}', 'Business\Roads\InventoryRoad\ProductionController@create')->name('create.production.inventory_roads');
            Route::post('roads/production/create/store', 'Business\Roads\InventoryRoad\ProductionController@store')->name('store.create.production.inventory_roads');
            Route::get('roads/production/edit/{gid}', 'Business\Roads\InventoryRoad\ProductionController@edit')->name('edit.production.inventory_roads');
            Route::post('roads/production/edit/update/{gid}', 'Business\Roads\InventoryRoad\ProductionController@update')->name('update.edit.production.inventory_roads');
            Route::get('roads/production/edit/show/{gid}', 'Business\Roads\InventoryRoad\ProductionController@show')->name('show.production.inventory_roads');

            Route::get('roads/transportation_services/index/{code}',
                'Business\Roads\InventoryRoad\TransportationServicesController@index')->name('index.transportation_services.inventory_roads');
            Route::get('roads/transportation_services/index_show/{code}',
                'Business\Roads\InventoryRoad\TransportationServicesController@indexShow')->name('index_show.index.transportation_services.inventory_roads');
            Route::get('roads/transportation_services/data/{code}',
                'Business\Roads\InventoryRoad\TransportationServicesController@data')->name('data.index.transportation_services.inventory_roads');
            Route::get('roads/transportation_services/create/{code}',
                'Business\Roads\InventoryRoad\TransportationServicesController@create')->name('create.transportation_services.inventory_roads');
            Route::post('roads/transportation_services/create/store',
                'Business\Roads\InventoryRoad\TransportationServicesController@store')->name('store.create.transportation_services.inventory_roads');
            Route::get('roads/transportation_services/edit/{gid}',
                'Business\Roads\InventoryRoad\TransportationServicesController@edit')->name('edit.transportation_services.inventory_roads');
            Route::post('roads/transportation_services/edit/update/{gid}',
                'Business\Roads\InventoryRoad\TransportationServicesController@update')->name('update.edit.transportation_services.inventory_roads');
            Route::get('roads/transportation_services/edit/show/{gid}',
                'Business\Roads\InventoryRoad\TransportationServicesController@show')->name('show.transportation_services.inventory_roads');

            Route::get('roads/social_information/index/{code}', 'Business\Roads\InventoryRoad\SocialInformationController@index')->name('index.social_information.inventory_roads');
            Route::get('roads/social_information/index_show/{code}',
                'Business\Roads\InventoryRoad\SocialInformationController@indexShow')->name('index_show.index.social_information.inventory_roads');
            Route::get('roads/social_information/data/{code}',
                'Business\Roads\InventoryRoad\SocialInformationController@data')->name('data.index.social_information.inventory_roads');
            Route::get('roads/social_information/create/{code}',
                'Business\Roads\InventoryRoad\SocialInformationController@create')->name('create.social_information.inventory_roads');
            Route::post('roads/social_information/create/store',
                'Business\Roads\InventoryRoad\SocialInformationController@store')->name('store.create.social_information.inventory_roads');
            Route::get('roads/social_information/edit/{gid}', 'Business\Roads\InventoryRoad\SocialInformationController@edit')->name('edit.social_information.inventory_roads');
            Route::post('roads/social_information/edit/update/{gid}',
                'Business\Roads\InventoryRoad\SocialInformationController@update')->name('update.edit.social_information.inventory_roads');
            Route::get('roads/social_information/edit/show/{gid}',
                'Business\Roads\InventoryRoad\SocialInformationController@show')->name('show.social_information.inventory_roads');

            Route::get('roads/shape/index/{code}', 'Business\Roads\InventoryRoad\ShapeController@index')->name('index.shape.inventory_roads');
            Route::get('roads/shape/index_show/{code}', 'Business\Roads\InventoryRoad\ShapeController@indexShow')->name('index_show.index.shape.inventory_roads');
            Route::get('roads/shape/data/{code}/{show}', 'Business\Roads\InventoryRoad\ShapeController@data')->name('data.index.shape.inventory_roads');
            Route::get('roads/shape/create/{code}', 'Business\Roads\InventoryRoad\ShapeController@create')->name('create.shape.inventory_roads');
            Route::post('roads/shape/create/store', 'Business\Roads\InventoryRoad\ShapeController@store')->name('store.create.shape.inventory_roads');
            Route::get('roads/shape/edit/{id}', 'Business\Roads\InventoryRoad\ShapeController@edit')->name('edit.shape.inventory_roads');
            Route::delete('roads/shape/destroy/{id}', 'Business\Roads\InventoryRoad\ShapeController@destroy')->name('destroy.shape.inventory_roads');
            Route::post('roads/shape/edit/update/{id}', 'Business\Roads\InventoryRoad\ShapeController@update')->name('update.edit.shape.inventory_roads');

            // Main shape
            Route::get('roads/main_shape/index', 'Business\Roads\InventoryRoad\MainShapeController@index')->name('index.main_shape');
            Route::get('roads/main_shape/data', 'Business\Roads\InventoryRoad\MainShapeController@data')->name('data.index.main_shape');
            Route::get('roads/main_shape/create', 'Business\Roads\InventoryRoad\MainShapeController@create')->name('create.main_shape');
            Route::post('roads/main_shape/create/store', 'Business\Roads\InventoryRoad\MainShapeController@store')->name('store.create.main_shape');
            Route::get('roads/main_shape/edit/{id}', 'Business\Roads\InventoryRoad\MainShapeController@edit')->name('edit.main_shape');
            Route::delete('roads/main_shape/destroy/{id}', 'Business\Roads\InventoryRoad\MainShapeController@destroy')->name('destroy.main_shape');
            Route::post('roads/main_shape/edit/update/{id}', 'Business\Roads\InventoryRoad\MainShapeController@update')->name('update.edit.main_shape');
            Route::get('roads/main_shape/all_shapes', 'Business\Roads\InventoryRoad\InventoryRoadController@allShapes')->name('all_shapes.index.main_shape');

            // Report roads
            Route::get('inventory_roads_report/index', 'Business\Reports\RoadsReportsController@index')->name('index.inventory_roads_report');

            Route::get('roads_reports', 'Business\Roads\InventoryRoad\InventoryRoadController@indexReport')->name('index.inventory_roads.inventory_roads_report');
            Route::get('roads_reports/data/{canton}/{parish}',
                'Business\Roads\InventoryRoad\InventoryRoadController@dataReportRoads')->name('data.index.inventory_roads.inventory_roads_report');
            Route::get('roads_reports/parish/{name}',
                'Business\Roads\InventoryRoad\InventoryRoadController@loadParishes')->name('parishes.index.inventory_roads.inventory_roads_report');

            Route::get('cantonal_road_length/index', 'Business\Reports\RoadsReportsController@indexRoadLength')->name('index.cantonal_road_length.inventory_roads_report');
            Route::get('cantonal_road_length/data', 'Business\Reports\RoadsReportsController@dataRoadLength')->name('data.index.cantonal_road_length.inventory_roads_report');

            Route::get('cantonal_road_status/index', 'Business\Reports\RoadsReportsController@indexRoadStatus')->name('index.cantonal_road_status.inventory_roads_report');
            Route::get('cantonal_road_status/data', 'Business\Reports\RoadsReportsController@dataRoadStatus')->name('data.index.cantonal_road_status.inventory_roads_report');

            Route::get('cantonal_road_total/index', 'Business\Reports\RoadsReportsController@indexRoadTotalLength')->name('index.cantonal_road_total.inventory_roads_report');
            Route::get('cantonal_road_total/data', 'Business\Reports\RoadsReportsController@dataRoadTotalLength')->name('data.index.cantonal_road_total.inventory_roads_report');

            Route::get('cantonal_road_general_status/index',
                'Business\Reports\RoadsReportsController@indexRoadGeneralStatus')->name('index.cantonal_road_general_status.inventory_roads_report');
            Route::get('cantonal_road_general_status/data',
                'Business\Reports\RoadsReportsController@dataRoadGeneralStatus')->name('data.index.cantonal_road_general_status.inventory_roads_report');

            // Roads catalogs
            Route::get('sewer_type/data', 'Business\Roads\Catalogs\SewerTypeController@data')->name('data.index.sewer_type.inventory_roads_catalogs');
            Route::resource('sewer_type', 'Business\Roads\Catalogs\SewerTypeController', [
                'parameters' => ['sewer_type' => 'descrip'],
                'names' => [
                    'index' => 'index.sewer_type.inventory_roads_catalogs',
                    'create' => 'create.sewer_type.inventory_roads_catalogs',
                    'store' => 'store.create.sewer_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('bridge_rolling_layer/data', 'Business\Roads\Catalogs\BridgeRollingLayerController@data')->name('data.index.bridge_rolling_layer.inventory_roads_catalogs');
            Route::resource('bridge_rolling_layer', 'Business\Roads\Catalogs\BridgeRollingLayerController', [
                'parameters' => ['bridge_rolling_layer' => 'descrip'],
                'names' => [
                    'index' => 'index.bridge_rolling_layer.inventory_roads_catalogs',
                    'create' => 'create.bridge_rolling_layer.inventory_roads_catalogs',
                    'store' => 'store.create.bridge_rolling_layer.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('interconnection_type/data', 'Business\Roads\Catalogs\InterconnectionTypeController@data')->name('data.index.interconnection_type.inventory_roads_catalogs');
            Route::resource('interconnection_type', 'Business\Roads\Catalogs\InterconnectionTypeController', [
                'parameters' => ['interconnection_type' => 'descrip'],
                'names' => [
                    'index' => 'index.interconnection_type.inventory_roads_catalogs',
                    'create' => 'create.interconnection_type.inventory_roads_catalogs',
                    'store' => 'store.create.interconnection_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('lanes/data', 'Business\Roads\Catalogs\LanesController@data')->name('data.index.lanes.inventory_roads_catalogs');
            Route::resource('lanes', 'Business\Roads\Catalogs\LanesController', [
                'parameters' => ['lanes' => 'descrip'],
                'names' => [
                    'index' => 'index.lanes.inventory_roads_catalogs',
                    'create' => 'create.lanes.inventory_roads_catalogs',
                    'store' => 'store.create.lanes.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('track_usage/data', 'Business\Roads\Catalogs\TrackUsageController@data')->name('data.index.track_usage.inventory_roads_catalogs');
            Route::resource('track_usage', 'Business\Roads\Catalogs\TrackUsageController', [
                'parameters' => ['track_usage' => 'descrip'],
                'names' => [
                    'index' => 'index.track_usage.inventory_roads_catalogs',
                    'create' => 'create.track_usage.inventory_roads_catalogs',
                    'store' => 'store.create.track_usage.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('ditch_type/data', 'Business\Roads\Catalogs\DitchTypeController@data')->name('data.index.ditch_type.inventory_roads_catalogs');
            Route::resource('ditch_type', 'Business\Roads\Catalogs\DitchTypeController', [
                'parameters' => ['ditch_type' => 'descrip'],
                'names' => [
                    'index' => 'index.ditch_type.inventory_roads_catalogs',
                    'create' => 'create.ditch_type.inventory_roads_catalogs',
                    'store' => 'store.create.ditch_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('weather_conditions/data', 'Business\Roads\Catalogs\WeatherConditionsController@data')->name('data.index.weather_conditions.inventory_roads_catalogs');
            Route::resource('weather_conditions', 'Business\Roads\Catalogs\WeatherConditionsController', [
                'parameters' => ['weather_conditions' => 'descrip'],
                'names' => [
                    'index' => 'index.weather_conditions.inventory_roads_catalogs',
                    'create' => 'create.weather_conditions.inventory_roads_catalogs',
                    'store' => 'store.create.weather_conditions.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('side/data', 'Business\Roads\Catalogs\SideController@data')->name('data.index.side.inventory_roads_catalogs');
            Route::resource('side', 'Business\Roads\Catalogs\SideController', [
                'parameters' => ['side' => 'descrip'],
                'names' => [
                    'index' => 'index.side.inventory_roads_catalogs',
                    'create' => 'create.side.inventory_roads_catalogs',
                    'store' => 'store.create.side.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('terrain_type/data', 'Business\Roads\Catalogs\TerrainTypeController@data')->name('data.index.terrain_type.inventory_roads_catalogs');
            Route::resource('terrain_type', 'Business\Roads\Catalogs\TerrainTypeController', [
                'parameters' => ['terrain_type' => 'descrip'],
                'names' => [
                    'index' => 'index.terrain_type.inventory_roads_catalogs',
                    'create' => 'create.terrain_type.inventory_roads_catalogs',
                    'store' => 'store.create.terrain_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('side_protections/data', 'Business\Roads\Catalogs\SideProtectionsController@data')->name('data.index.side_protections.inventory_roads_catalogs');
            Route::resource('side_protections', 'Business\Roads\Catalogs\SideProtectionsController', [
                'parameters' => ['side_protections' => 'descrip'],
                'names' => [
                    'index' => 'index.side_protections.inventory_roads_catalogs',
                    'create' => 'create.side_protections.inventory_roads_catalogs',
                    'store' => 'store.create.side_protections.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('status/data', 'Business\Roads\Catalogs\StatusController@data')->name('data.index.status.inventory_roads_catalogs');
            Route::resource('status', 'Business\Roads\Catalogs\StatusController', [
                'parameters' => ['status' => 'descrip'],
                'names' => [
                    'index' => 'index.status.inventory_roads_catalogs',
                    'create' => 'create.status.inventory_roads_catalogs',
                    'store' => 'store.create.status.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('sewer_material/data', 'Business\Roads\Catalogs\SewerMaterialController@data')->name('data.index.sewer_material.inventory_roads_catalogs');
            Route::resource('sewer_material', 'Business\Roads\Catalogs\SewerMaterialController', [
                'parameters' => ['sewer_material' => 'descrip'],
                'names' => [
                    'index' => 'index.sewer_material.inventory_roads_catalogs',
                    'create' => 'create.sewer_material.inventory_roads_catalogs',
                    'store' => 'store.create.sewer_material.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('rolling_surface_type/data', 'Business\Roads\Catalogs\RollingSurfaceTypeController@data')->name('data.index.rolling_surface_type.inventory_roads_catalogs');
            Route::resource('rolling_surface_type', 'Business\Roads\Catalogs\RollingSurfaceTypeController', [
                'parameters' => ['rolling_surface_type' => 'descrip'],
                'names' => [
                    'index' => 'index.rolling_surface_type.inventory_roads_catalogs',
                    'create' => 'create.rolling_surface_type.inventory_roads_catalogs',
                    'store' => 'store.create.rolling_surface_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('material_type/data', 'Business\Roads\Catalogs\MaterialTypeController@data')->name('data.index.material_type.inventory_roads_catalogs');
            Route::resource('material_type', 'Business\Roads\Catalogs\MaterialTypeController', [
                'parameters' => ['material_type' => 'descrip'],
                'names' => [
                    'index' => 'index.material_type.inventory_roads_catalogs',
                    'create' => 'create.material_type.inventory_roads_catalogs',
                    'store' => 'store.create.material_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('climatic_floor/data', 'Business\Roads\Catalogs\ClimaticFloorController@data')->name('data.index.climatic_floor.inventory_roads_catalogs');
            Route::resource('climatic_floor', 'Business\Roads\Catalogs\ClimaticFloorController', [
                'parameters' => ['climatic_floor' => 'descrip'],
                'names' => [
                    'index' => 'index.climatic_floor.inventory_roads_catalogs',
                    'create' => 'create.climatic_floor.inventory_roads_catalogs',
                    'store' => 'store.create.climatic_floor.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('rolling_surface/data', 'Business\Roads\Catalogs\RollingSurfaceController@data')->name('data.index.rolling_surface.inventory_roads_catalogs');
            Route::resource('rolling_surface', 'Business\Roads\Catalogs\RollingSurfaceController', [
                'parameters' => ['rolling_surface' => 'descrip'],
                'names' => [
                    'index' => 'index.rolling_surface.inventory_roads_catalogs',
                    'create' => 'create.rolling_surface.inventory_roads_catalogs',
                    'store' => 'store.create.rolling_surface.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('critical_point_type/data', 'Business\Roads\Catalogs\CriticalPointTypeController@data')->name('data.index.critical_point_type.inventory_roads_catalogs');
            Route::resource('critical_point_type', 'Business\Roads\Catalogs\CriticalPointTypeController', [
                'parameters' => ['critical_point_type' => 'descrip'],
                'names' => [
                    'index' => 'index.critical_point_type.inventory_roads_catalogs',
                    'create' => 'create.critical_point_type.inventory_roads_catalogs',
                    'store' => 'store.create.critical_point_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('drainage_type/data', 'Business\Roads\Catalogs\DrainageTypeController@data')->name('data.index.drainage_type.inventory_roads_catalogs');
            Route::resource('drainage_type', 'Business\Roads\Catalogs\DrainageTypeController', [
                'parameters' => ['drainage_type' => 'descrip'],
                'names' => [
                    'index' => 'index.drainage_type.inventory_roads_catalogs',
                    'create' => 'create.drainage_type.inventory_roads_catalogs',
                    'store' => 'store.create.drainage_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('productive_sector/data', 'Business\Roads\Catalogs\ProductiveSectorController@data')->name('data.index.productive_sector.inventory_roads_catalogs');
            Route::resource('productive_sector', 'Business\Roads\Catalogs\ProductiveSectorController', [
                'parameters' => ['productive_sector' => 'descrip'],
                'names' => [
                    'index' => 'index.productive_sector.inventory_roads_catalogs',
                    'create' => 'create.productive_sector.inventory_roads_catalogs',
                    'store' => 'store.create.productive_sector.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('source/data', 'Business\Roads\Catalogs\SourceController@data')->name('data.index.source.inventory_roads_catalogs');
            Route::resource('source', 'Business\Roads\Catalogs\SourceController', [
                'parameters' => ['source' => 'descrip'],
                'names' => [
                    'index' => 'index.source.inventory_roads_catalogs',
                    'create' => 'create.source.inventory_roads_catalogs',
                    'store' => 'store.create.source.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('mines_type/data', 'Business\Roads\Catalogs\MinesTypeController@data')->name('data.index.mines_type.inventory_roads_catalogs');
            Route::resource('mines_type', 'Business\Roads\Catalogs\MinesTypeController', [
                'parameters' => ['mines_type' => 'descrip'],
                'names' => [
                    'index' => 'index.mines_type.inventory_roads_catalogs',
                    'create' => 'create.mines_type.inventory_roads_catalogs',
                    'store' => 'store.create.mines_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('drainage_status/data', 'Business\Roads\Catalogs\DrainageStatusController@data')->name('data.index.drainage_status.inventory_roads_catalogs');
            Route::resource('drainage_status', 'Business\Roads\Catalogs\DrainageStatusController', [
                'parameters' => ['drainage_status' => 'descrip'],
                'names' => [
                    'index' => 'index.drainage_status.inventory_roads_catalogs',
                    'create' => 'create.drainage_status.inventory_roads_catalogs',
                    'store' => 'store.create.drainage_status.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('horizontal_signal_type/data',
                'Business\Roads\Catalogs\HorizontalSignalTypeController@data')->name('data.index.horizontal_signal_type.inventory_roads_catalogs');
            Route::resource('horizontal_signal_type', 'Business\Roads\Catalogs\HorizontalSignalTypeController', [
                'parameters' => ['horizontal_signal_type' => 'descrip'],
                'names' => [
                    'index' => 'index.horizontal_signal_type.inventory_roads_catalogs',
                    'create' => 'create.horizontal_signal_type.inventory_roads_catalogs',
                    'store' => 'store.create.horizontal_signal_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('vertical_signal_type/data', 'Business\Roads\Catalogs\VerticalSignalTypeController@data')->name('data.index.vertical_signal_type.inventory_roads_catalogs');
            Route::resource('vertical_signal_type', 'Business\Roads\Catalogs\VerticalSignalTypeController', [
                'parameters' => ['vertical_signal_type' => 'descrip'],
                'names' => [
                    'index' => 'index.vertical_signal_type.inventory_roads_catalogs',
                    'create' => 'create.vertical_signal_type.inventory_roads_catalogs',
                    'store' => 'store.create.vertical_signal_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('firm_type/data', 'Business\Roads\Catalogs\FirmTypeController@data')->name('data.index.firm_type.inventory_roads_catalogs');
            Route::resource('firm_type', 'Business\Roads\Catalogs\FirmTypeController', [
                'parameters' => ['firm_type' => 'descrip'],
                'names' => [
                    'index' => 'index.firm_type.inventory_roads_catalogs',
                    'create' => 'create.firm_type.inventory_roads_catalogs',
                    'store' => 'store.create.firm_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('population_type/data', 'Business\Roads\Catalogs\PopulationTypeController@data')->name('data.index.population_type.inventory_roads_catalogs');
            Route::resource('population_type', 'Business\Roads\Catalogs\PopulationTypeController', [
                'parameters' => ['population_type' => 'descrip'],
                'names' => [
                    'index' => 'index.population_type.inventory_roads_catalogs',
                    'create' => 'create.population_type.inventory_roads_catalogs',
                    'store' => 'store.create.population_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('slope_type/data', 'Business\Roads\Catalogs\SlopeTypeController@data')->name('data.index.slope_type.inventory_roads_catalogs');
            Route::resource('slope_type', 'Business\Roads\Catalogs\SlopeTypeController', [
                'parameters' => ['slope_type' => 'descrip'],
                'names' => [
                    'index' => 'index.slope_type.inventory_roads_catalogs',
                    'create' => 'create.slope_type.inventory_roads_catalogs',
                    'store' => 'store.create.slope_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('associated_service_type/data',
                'Business\Roads\Catalogs\AssociatedServiceTypeController@data')->name('data.index.associated_service_type.inventory_roads_catalogs');
            Route::resource('associated_service_type', 'Business\Roads\Catalogs\AssociatedServiceTypeController', [
                'parameters' => ['associated_service_type' => 'descrip'],
                'names' => [
                    'index' => 'index.associated_service_type.inventory_roads_catalogs',
                    'create' => 'create.associated_service_type.inventory_roads_catalogs',
                    'store' => 'store.create.associated_service_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('type_conservation_need/data',
                'Business\Roads\Catalogs\TypeConservationNeedController@data')->name('data.index.type_conservation_need.inventory_roads_catalogs');
            Route::resource('type_conservation_need', 'Business\Roads\Catalogs\TypeConservationNeedController', [
                'parameters' => ['type_conservation_need' => 'descrip'],
                'names' => [
                    'index' => 'index.type_conservation_need.inventory_roads_catalogs',
                    'create' => 'create.type_conservation_need.inventory_roads_catalogs',
                    'store' => 'store.create.type_conservation_need.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('day_type/data', 'Business\Roads\Catalogs\DayTypeController@data')->name('data.index.day_type.inventory_roads_catalogs');
            Route::resource('day_type', 'Business\Roads\Catalogs\DayTypeController', [
                'parameters' => ['day_type' => 'descrip'],
                'names' => [
                    'index' => 'index.day_type.inventory_roads_catalogs',
                    'create' => 'create.day_type.inventory_roads_catalogs',
                    'store' => 'store.create.day_type.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('mines_material/data', 'Business\Roads\Catalogs\MinesMaterialController@data')->name('data.index.mines_material.inventory_roads_catalogs');
            Route::resource('mines_material', 'Business\Roads\Catalogs\MinesMaterialController', [
                'parameters' => ['mines_material' => 'descrip'],
                'names' => [
                    'index' => 'index.mines_material.inventory_roads_catalogs',
                    'create' => 'create.mines_material.inventory_roads_catalogs',
                    'store' => 'store.create.mines_material.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);

            Route::get('support_services/data', 'Business\Roads\Catalogs\SupportServicesController@data')->name('data.index.support_services.inventory_roads_catalogs');
            Route::get('support_services/download_image/{gid}',
                'Business\Roads\Catalogs\SupportServicesController@downloadImage')->name('download_image.index.support_services.inventory_roads_catalogs');
            Route::resource('support_services', 'Business\Roads\Catalogs\SupportServicesController', [
                'parameters' => ['support_services' => 'descrip'],
                'names' => [
                    'index' => 'index.support_services.inventory_roads_catalogs',
                    'create' => 'create.support_services.inventory_roads_catalogs',
                    'store' => 'store.create.support_services.inventory_roads_catalogs'
                ]
            ])->except(['destroy', 'update', 'show', 'edit']);
        }
    );

    Route::get('/reports/projects/{executingUnitId}', [\App\Http\Controllers\Business\Reports\PlanningReportsController::class, 'loadProjects'])->name('projects.poa.reports');

});

