<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use Illuminate\Support\Facades\Cache;

class StatisticAction extends Action
{
    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * @return array{month: mixed, year: mixed, active_category: mixed, active_work: mixed, error_work: mixed, lead: mixed[]}
     */
    public function indexStatistic(): array
    {
        return [
            'month' => Cache::get('statsMonth') ? Cache::get('statsMonth') : 0,
            'year' => Cache::get('statsYear') ? Cache::get('statsYear') : 0,
            'active_category' => Cache::get('activeCategory') ? Cache::get('activeCategory') : 0,
            'active_work' => Cache::get('activeWork') ? Cache::get('activeWork') : 0,
            'error_work' => Cache::get('errorWork') ? Cache::get('errorWork') : 0,
            'lead' => Cache::get('lead') ? Cache::get('lead') : ['day' => 0, 'hour' => 0, 'minute' => 0],
        ];
    }
}
