<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use App\Requests\PriorityRequest;
use Illuminate\Http\JsonResponse;

class PriorityApiController extends Controller
{
    private string $data;
    private PriorityAction $priorities;
    public function __construct(PriorityAction $priorities)
    {
        $this->priorities = $priorities;
    }

    public function store(PriorityRequest $request): JsonResponse
    {
        $this->data = $this->priorities->store($request->validated());
        return response()->json($this->data);
    }

    public function update(PriorityRequest $request, int $priority): JsonResponse
    {
        $this->data = $this->priorities->update($request->validated(), $priority);
        return response()->json($this->data);
    }

    public function destroy(int $priority): JsonResponse
    {
        $this->data = $this->priorities->delete($priority);
        return response()->json($this->data);
    }
}
