<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticAction extends Action
{
    public Carbon $today;

    protected array $lead = ['day' => 0, 'hour' => 0, 'minute' => 0];

    public $leadSum;

    public $leadCount;

    public function __construct()
    {
        //parent::__construct();
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
     * @return array{month: mixed, year: mixed, active_category: mixed, active_work: mixed, error_work: mixed, lead: mixed[]}
     */
    public function indexStatistic(): array
    {
        $today = Carbon::now();
        $leadSum = Help::whereNotNull('calendar_final')->whereYear('calendar_accept', '=', $today->year)->sum('lead_at');
        $leadCount = Help::whereNotNull('calendar_final')->whereYear('calendar_accept', '=', $today->year)->count();
        if ($leadSum !== 0 || $leadCount !== 0) {
            $this->lead = $this->getTime($leadSum / $leadCount);
        }

        return [
            'month' => Help::whereMonth('calendar_request', '=', $today->month)->count(),
            'year' => Help::whereYear('calendar_request', '=', $today->year)->count(),
            'active_category' => Help::join('category', 'category.id', '=', 'help.category_id')
                ->select(DB::raw('count("category_id") AS categoryId,category_id,category.description'))
                ->whereYear('calendar_request', '=', $today->year)
                ->groupBy('category_id', 'category.description')
                ->orderBy(DB::raw('count("category_id")'), 'DESC')
                ->first(),
            'active_work' => Help::join('users', 'users.id', '=', 'help.user_id')
                ->select(DB::raw('count("user_id") AS userId,user_id,users.firstname,users.lastname,users.patronymic'))
                ->whereYear('calendar_request', '=', $today->year)
                ->groupBy('user_id', 'users.firstname', 'users.lastname', 'users.patronymic')
                ->orderBy(DB::raw('count("user_id")'), 'DESC')
                ->first(),
            'error_work' => Help::join('users', 'users.id', '=', 'help.user_id')
                ->select(DB::raw('count("user_id") AS userId,user_id,users.firstname,users.lastname,users.patronymic'))
                ->whereYear('calendar_request', '=', $today->year)
                ->where('status_id', '=', config('constants.request.danger'))
                ->groupBy('user_id', 'users.firstname', 'users.lastname', 'users.patronymic')
                ->orderBy(DB::raw('count("user_id")'), 'DESC')
                ->first(),
            'lead' => $this->lead,
        ];
    }
}
