<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use App\Requests\CabinetRequest;
use Illuminate\Http\JsonResponse;

class CabinetApiController extends Controller
{
    /**
     * [result data]
     */
    private JsonResponse $data;

    /**
     * [add new cabinet]
     */
    public function store(CabinetRequest $request, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->store($request->validated());

        return $this->data;
    }

    /**
     * [update cabinet]
     */
    public function update(CabinetRequest $request, int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->update($request->validated(), $cabinet);

        return $this->data;
    }

    /**
     * [delete cabinet]
     */
    public function destroy(int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->delete($cabinet);

        return $this->data;
    }
}
