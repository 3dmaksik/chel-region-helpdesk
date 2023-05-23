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
    public $tries = 10;

    public $maxExceptions = 2;

    public $timeout = 120;

    private Collection $items;

    private User $user;

    private int $count;

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
        $this->items = Help::dontCache()->where('calendar_execution', '<', $this->warning)
            ->where('calendar_warning', '<', $this->warning)
            ->where('status_id', 2)
            ->orderBy('calendar_execution', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        $this->count = Help::dontCache()->where('calendar_execution', '<', $this->warning)
            ->where('calendar_warning', '<', $this->warning)
            ->where('status_id', 2)
            ->count() - 1;
        if ($this->items !== null) {
            foreach ($this->items as $item) {
                $this->user = User::dontCache()->findOrFail($item->executor_id);
                if ($this->user->getRoleNames()[0] != 'user') {
                    Notification::send($this->user, new ExpireNotification('expire', $item->app_number, $this->count));
                }
            }
        }
    }
}
