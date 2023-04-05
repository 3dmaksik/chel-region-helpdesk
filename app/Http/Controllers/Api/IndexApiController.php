<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HomeAction;
use App\Requests\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexApiController extends Controller
{
    private string $data;

    private HomeAction $helps;

    public function __construct(HomeAction $helps)
    {
        $this->helps = $helps;
    }

    public function store(IndexRequest $request): JsonResponse
    {
        $this->data = $this->helps->store($request->validated());

        return response()->json($this->data);
    }
}
