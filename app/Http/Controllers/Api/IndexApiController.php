<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\Help\IndexUserRequest;
use Illuminate\Http\JsonResponse;

class IndexApiController extends Controller
{
    /**
     * [add new help]
     */
    public function store(IndexUserRequest $request, HelpAction $helps): JsonResponse
    {
        $this->data = $helps->store($request->validated(null, null));

        return $this->data;
    }
}
