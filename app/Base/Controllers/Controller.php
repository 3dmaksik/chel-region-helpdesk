<?php

namespace App\Base\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Http\JsonResponse;

class Controller extends LaravelController
{
	use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
	
    /**
     * [result data api]
     */
    public JsonResponse $data;
}
