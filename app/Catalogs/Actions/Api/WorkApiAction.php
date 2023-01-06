<?php

namespace App\Catalogs\Actions\Api;

use App\Base\Actions\Action;
use App\Models\Work;

class WorkApiAction extends Action
{
    public function getDataWork() : Work
    {
        return Work::where('user_id', auth()->user()->id)->first();
    }
}
