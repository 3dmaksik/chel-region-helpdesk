<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use App\Requests\CabinetRequest;
use Illuminate\Http\JsonResponse;

final class CabinetApiController extends Controller
{
    /**
     * [add new cabinet]
     */
    public function store(CabinetRequest $request, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update cabinet]
     */
    public function update(CabinetRequest $request, int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->update($request->validated(null, null), $cabinet);

        return $this->data;
    }

    /**
     * [delete cabinet]
     */
    public function destroy(int $cabinet, CabinetAction $cabinetAction): JsonResponse
    {
        $this->data = $cabinetAction->destroy($cabinet);

        return $this->data;
    }
}
