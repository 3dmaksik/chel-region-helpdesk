<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use App\Requests\StatusRequest;
use Illuminate\Http\JsonResponse;

final class StatusApiController extends Controller
{
    /**
     * [update status]
     */
    public function update(StatusRequest $request, int $status, StatusAction $statusAction): JsonResponse
    {
        $this->data = $statusAction->update($request->validated(null, null), $status);

        return $this->data;
    }
}
