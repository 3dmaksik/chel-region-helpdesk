<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatisticAction;
use App\Models\Help;
use Illuminate\View\View;

class StatisticController extends Controller
{
    private StatisticAction $statistic;

    public Help $item;

    public function __construct(StatisticAction $statistic)
    {
        $this->statistic = $statistic;
    }

    public function index(): View
    {
        $data = $this->statistic->indexStatistic();

        return view('forms.show.statistic', compact('data'));
    }
}
