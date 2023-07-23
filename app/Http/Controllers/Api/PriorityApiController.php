<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use App\Requests\PriorityRequest;
use Illuminate\Http\JsonResponse;

final class PriorityApiController extends Controller
{
    /**
     * [add new priority]
     */
    public function store(PriorityRequest $request, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update priority]
     */
    public function update(PriorityRequest $request, int $priority, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->update($request->validated(null, null), $priority);

        return $this->data;
    }

    /**
     * [delete priority]
     */
    public function destroy(int $priority, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->destroy($priority);

        return $this->data;
    }
}
