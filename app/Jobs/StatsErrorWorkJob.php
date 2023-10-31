<?php

namespace App\Jobs;

use App\Base\Enums\Status;
use App\Base\Jobs\Job;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatsErrorWorkJob extends Job implements ShouldQueue
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
        Cache::forget('errorWork');
        Cache::remember('errorWork', Carbon::now()->addHour(), function () {
            return Help::join('users', 'users.id', '=', 'help.user_id')
                ->select(DB::raw('count("user_id") AS userId,user_id,users.firstname,users.lastname,users.patronymic'))
                ->whereYear('calendar_request', '=', $this->today->year)
                ->where('status_id', '=', Status::Danger)
                ->groupBy('user_id', 'users.firstname', 'users.lastname', 'users.patronymic')
                ->orderBy(DB::raw('count("user_id")'), 'DESC')
                ->first();
        });
    }
}
