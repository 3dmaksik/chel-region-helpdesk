<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HomeAction;
use App\Requests\IndexRequest;
use Illuminate\Http\JsonResponse;

class HomeApiController extends Controller
{
    private JsonResponse $data;

    private HomeAction $helps;

    public function __construct(HomeAction $helps)
    {
        $this->helps = $helps;
    }

    public function store(IndexRequest $request): JsonResponse
    {
        $this->data = $this->helps->store($request);

        return $this->data;
    }
}
