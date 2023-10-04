<?php

namespace App\Jobs;

use App\Base\Jobs\Job;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class StatsLeadJob extends Job implements ShouldQueue
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
     * [lead time]
     *
     * @var array lead
     */
    protected array $lead = ['day' => 0, 'hour' => 0, 'minute' => 0];

    /**
     * [lead sum]
     *
     * @var int leadSum
     */
    protected int $leadSum;

    /**
     * [lead count]
     *
     * @var int leadCount
     */
    protected int $leadCount;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return array{day: int, hour: int, minute: int}
     */
    private function getTime(float $value): array
    {
        $day = floor($value / 86400);
        $value = $value % 86400;
        $hour = floor($value / 3600);
        $value = $value % 3600;
        $minute = floor($value / 60);

        return
       [
           'day' => (int) $day,
           'hour' => (int) $hour,
           'minute' => (int) $minute,
       ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->today = Carbon::now();
        Cache::forget('leadSum');
        $this->leadSum = Cache::remember('leadSum', Carbon::now()->addHour(), function () {
            return Help::whereNotNull('calendar_final')->whereYear('calendar_accept', '=', $this->today->year)->sum('lead_at');
        });
        Cache::forget('leadCount');
        $this->leadCount = Cache::remember('leadCount', Carbon::now()->addHour(), function () {
            return Help::whereNotNull('calendar_final')->whereYear('calendar_accept', '=', $this->today->year)->count();
        });
        if ($this->leadSum !== 0 || $this->leadCount !== 0) {
            Cache::forget('lead');
            $this->lead = Cache::remember('lead', Carbon::now()->addHour(), function () {
                return $this->getTime($this->leadSum / $this->leadCount);
            });
        }
    }
}
