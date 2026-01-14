<?php

namespace App\Listeners;

use App\Events\ActivityAreaChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class UpdateActivityBudgetItemsAreaCode
{

    /**
     * Handle the event.
     *
     * @param ActivityAreaChanged $event
     *
     * @return void
     */
    public function handle(ActivityAreaChanged $event)
    {
        DB::update("update budget_items bi
                            set code = concat(a.code, substring(bi.code, 3))
                            from activity_project_fiscal_years apfy
                            inner join areas a on apfy.area_id = a.id
                            where bi.activity_project_fiscal_year_id = apfy.id
                            and substring(bi.code, 1, 2) <> a.code
                            and apfy.id = ?", [$event->activityProjectFiscalYear->id]);
    }
}
