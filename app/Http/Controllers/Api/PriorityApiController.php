<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use App\Requests\PriorityRequest;
use Illuminate\Http\JsonResponse;

class PriorityApiController extends Controller
{
    /**
     * [result data]
     */
    private JsonResponse $data;

    /**
     * [add new priority]
     */
    public function store(PriorityRequest $request, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->store($request->validated());

        return $this->data;
    }

    /**
     * [update priority]
     */
    public function update(PriorityRequest $request, int $priority, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->update($request->validated(), $priority);

        return $this->data;
    }

    /**
     * [delete priority]
     */
    public function destroy(int $priority, PriorityAction $priorityAction): JsonResponse
    {
        $this->data = $priorityAction->delete($priority);

        return $this->data;
    }
}
