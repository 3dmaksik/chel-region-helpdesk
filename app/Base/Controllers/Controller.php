<?php

namespace App\Base\Controllers;

use App\Core\Controllers\CoreController;
use Illuminate\Http\JsonResponse;

class Controller extends CoreController
{
    /**
     * [result data api]
     */
    public JsonResponse $data;
}
