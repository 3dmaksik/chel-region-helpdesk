<?php

namespace App\Jobs;

use App\Base\Jobs\Job;
use App\Models\Help;
use App\Models\User;
use App\Notifications\ExpireNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class NotifyExpireJob extends Job implements ShouldQueue
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
     * [all items]
     *
     * @var items
     */
    private Collection $items;

    /**
     * [this user for notify]
     */
    private User $user;

    /**
     * [now date]
     */
    private Carbon $warning;

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
        $this->warning = Carbon::now();
        $this->items = Help::where('calendar_execution', '<', $this->warning)
            ->where('calendar_warning', '<', $this->warning)
            ->where('status_id', config('constants.request.work'))
            ->orderBy('calendar_execution', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        if ($this->items !== null) {
            foreach ($this->items as $item) {
                $this->user = User::findOrFail($item->executor_id);
                if ($this->user->getRoleNames()[0] !== 'user') {
                    Notification::send($this->user, new ExpireNotification('expire', $item->app_number, $this->items->count() - 1));
                }
            }
        }
    }
}
