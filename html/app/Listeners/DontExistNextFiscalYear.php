<?php

namespace App\Listeners;

use App\Events\CreateNextFiscalyear;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DontExistNextFiscalYear
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
     * @param \App\Events\CreateNextFiscalyear $event
     * @return void
     */
    public function handle(CreateNextFiscalyear $event)
    {
        //
        $model = $event->fiscalYear;
        $fiscalYear = $model->where('year', Carbon::now()->year)->first();
        $nextFiscalYear = $model->where('year', Carbon::now()->addYear()->year)->first();
        if (!$nextFiscalYear) {
            $model->create(
                [
                    'year' => $fiscalYear->year + 1
                ]);
        }

    }
}
