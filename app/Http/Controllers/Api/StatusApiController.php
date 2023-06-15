<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use App\Requests\StatusRequest;
use Illuminate\Http\JsonResponse;

class StatusApiController extends Controller
{
    /**
     * [result data]
     */
    private JsonResponse $data;

    /**
     * [update status]
     */
    public function update(StatusRequest $request, int $status, StatusAction $statusAction): JsonResponse
    {
        $this->data = $statusAction->update($request->validated(), $status);

        return $this->data;
    }
}
