<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatisticAction;
use App\Models\Help;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public Help $item;

    public function __construct(private readonly StatisticAction $statistic)
    {
    }

    public function index(): View
    {
        $data = $this->statistic->indexStatistic();

        return view('forms.show.statistic', compact('data'));
    }
}
