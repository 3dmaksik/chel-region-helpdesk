<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

class HomeApiController extends Controller
{
    /**
     * [add new help]
     */
    public function store(HelpRequest $request, HelpAction $helps): JsonResponse
    {
        $this->data = $helps->store($request->validated(null, null));

        return $this->data;
    }
}
