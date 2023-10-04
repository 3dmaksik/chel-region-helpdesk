<?php

namespace App\Jobs;

use App\Base\Jobs\Job;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class StatsMonthJob extends Job implements ShouldQueue
{
    /**
     * [tries for job]
     *
     * @var tries
     */
    public $tries = 10;

    /**
     * [max exceptions for job]
     *
     * @var maxExceptions
     */
    public $maxExceptions = 2;

    /**
     * [timeout for job]
     *
     * @var timeout
     */
    public $timeout = 120;

    /**
     * [now time]
     *
     * @var Carbon today
     */
    protected Carbon $today;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->today = Carbon::now();
        Cache::forget('StatsMonth');
        Cache::remember('statsMonth', Carbon::now()->addHour(), function () {
            return Help::whereMonth('calendar_request', '=', $this->today->month)->count();
        });
    }
}
