<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use App\Requests\CabinetRequest;
use Illuminate\Http\JsonResponse;

class CabinetApiController extends Controller
{
    private JsonResponse $data;

    private CabinetAction $cabinets;

    public function __construct(CabinetAction $cabinets)
    {
        $this->cabinets = $cabinets;
    }

    public function store(CabinetRequest $request): JsonResponse
    {
        $this->data = $this->cabinets->store($request->validated());

        return $this->data;
    }

    public function update(CabinetRequest $request, int $cabinet): JsonResponse
    {
        $this->data = $this->cabinets->update($request->validated(), $cabinet);

        return $this->data;
    }

    public function destroy(int $cabinet): JsonResponse
    {
        $this->data = $this->cabinets->delete($cabinet);

        return $this->data;
    }
}
