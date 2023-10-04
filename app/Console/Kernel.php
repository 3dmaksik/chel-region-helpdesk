<?php

namespace App\Console;

use App\Jobs\ClearImageJob;
use App\Jobs\NotifyExpireJob;
use App\Jobs\StatsActiveCategoryJob;
use App\Jobs\StatsActiveWorkJob;
use App\Jobs\StatsErrorWorkJob;
use App\Jobs\StatsLeadJob;
use App\Jobs\StatsMonthJob;
use App\Jobs\StatsYearJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ClearImageJob)->daily();
        $schedule->job(new NotifyExpireJob)->hourly();
        $schedule->job(new StatsLeadJob)->hourly();
        $schedule->job(new StatsYearJob)->hourly();
        $schedule->job(new StatsMonthJob)->hourly();
        $schedule->job(new StatsActiveCategoryJob)->hourly();
        $schedule->job(new StatsActiveWorkJob)->hourly();
        $schedule->job(new StatsErrorWorkJob)->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
