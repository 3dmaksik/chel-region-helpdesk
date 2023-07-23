<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HomeAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

class HomeApiController extends Controller
{
    public function __construct(private readonly HomeAction $helps)
    {
    }

    public function store(HelpRequest $request): JsonResponse
    {
        $this->data = $this->helps->store($request);

        return $this->data;
    }
}
