<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use App\Requests\StatusRequest;
use Illuminate\Http\JsonResponse;

class StatusApiController extends Controller
{
    private JsonResponse $data;

    private StatusAction $statuses;

    public function __construct(StatusAction $statuses)
    {
        $this->statuses = $statuses;
    }

    public function update(StatusRequest $request, int $status): JsonResponse
    {
        $this->data = $this->statuses->store($request->validated(), $status);

        return $this->data;
    }
}
