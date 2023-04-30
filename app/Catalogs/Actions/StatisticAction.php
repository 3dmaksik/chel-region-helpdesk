<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticAction extends Action
{
    public Carbon $today;

    public function __construct()
    {
        //parent::__construct();
    }

    public function indexStatistic(): array
    {
        $today = Carbon::now();

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
                ->where('status_id', '=', '4')
                ->groupBy('user_id', 'users.firstname', 'users.lastname', 'users.patronymic')
                ->orderBy(DB::raw('count("user_id")'), 'DESC')
                ->first(),
        ];
    }
}
