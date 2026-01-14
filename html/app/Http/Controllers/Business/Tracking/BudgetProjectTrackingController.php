<?php

namespace App\Http\Controllers\Business\Tracking;

use App\Exports\DefaultReportExport;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Processes\Business\Tracking\BudgetProjectTrackingProcess;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

/**
 * Clase BudgetProjectTrackingController
 * @package App\Http\Controllers\Business\Tracking
 */
class BudgetProjectTrackingController extends Controller
{
    /**
     * @var BudgetProjectTrackingProcess
     */
    private $budgetProjectTrackingProcess;

    /**
     * Constructor de ProjectTracking.
     *
     * @param BudgetProjectTrackingProcess $budgetProjectTrackingProcess
     */
    public function __construct(BudgetProjectTrackingProcess $budgetProjectTrackingProcess)
    {
        $this->budgetProjectTrackingProcess = $budgetProjectTrackingProcess;
    }

    /**
     * Llamada al proceso para mostrar vista de seguimiento de proyectos.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            setlocale(LC_TIME, 'es_ES.utf8');
            $response['view'] = view('business.tracking.projects.budget.index', [
                'projectId' => $id,
                'currentMonth' => strtoupper(now()->formatLocalized('%B'))
            ])->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Procesa la petición ajax de datatables.
     *
     * @param int $id
     *
     * @return string
     */
    public function data(int $id)
    {
        try {
            return $this->budgetProjectTrackingProcess->data($id);
        } catch (QueryException $e) {
            return datatableEmptyResponse(new Exception(trans('app.messages.exceptions.sfgprov_not_available')), $e);
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Exporta el avance presupuestario a excel.
     *
     * @param int $id
     *
     * @return mixed|string
     */
      public function dataExport(int $id)
    {
        $data = $this->budgetProjectTrackingProcess->dataExport($id);

        $rowsRaw = $data['rows'] ?? [];
        $rows = array_map(fn($item) => (object) $item, $rowsRaw);

        \Illuminate\Support\Facades\Log::info('Data Export', ['rows' => $rows]);

        $projectName = $data['projectName'] ?? 'Proyecto sin nombre';
        $date = $data['date'] ?? '';

        return Excel::download(
            new DefaultReportExport(
                'business.tracking.projects.budget.table',
                [
                    'rows' => $rows,
                    'projectName' => $projectName,
                    'date' => $date
                ],
                "Avance Presupuestario"
            ),
            trans('budget_project_tracking.labels.file_name') . '.xlsx'
        );
    }

  /*  public function dataExport(int $id)
    {
        try {

            $data = $this->budgetProjectTrackingProcess->dataExport($id);

            $view = view('business.tracking.projects.budget.table', $data);

            return Excel::download(new DefaultReportExport($view), trans('budget_project_tracking.labels.file_name') . '.xlsx');
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }*/
}
