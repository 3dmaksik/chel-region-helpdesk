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
     *
     * @param array{description: int}
     * @param type [$cabinetAction] cabinetAction
     */
    public function store(CabinetRequest $request, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update cabinet]
     *
     * @param array{description: int}
     * @param type [$cabinetAction] cabinetAction
     */
    public function update(CabinetRequest $request, int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->update($request->validated(null, null), $cabinet);

        return $this->data;
    }

    /**
     * [delete cabinet]
     *
     * @param type [$cabinetAction] cabinetAction
     */
    public function destroy(int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->destroy($cabinet);

        return $this->data;
    }
}
