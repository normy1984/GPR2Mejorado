<?php

namespace App\Listeners;

use App\Events\ProgramAreaChanged;
use App\Events\ProjectExecutingUnitChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class ProjectBudgetItemsExecutingUnitCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProjectExecutingUnitChanged $event
     *
     * @return void
     */
    public function handle(ProjectExecutingUnitChanged $event)
    {
        try {

            DB::update("UPDATE budget_items bi
                                SET code = CONCAT(left(bi.code, 13), $event->code::text, substring(bi.code, 17))
                                FROM activity_project_fiscal_years apfy
                                INNER JOIN project_fiscal_years pfy ON apfy.project_fiscal_year_id = pfy.id
                                WHERE bi.activity_project_fiscal_year_id = apfy.id AND pfy.id = $event->projectFiscalYearId");

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
