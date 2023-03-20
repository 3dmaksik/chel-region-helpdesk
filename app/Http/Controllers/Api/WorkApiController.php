<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\Api\WorkApiAction;
use Illuminate\Http\JsonResponse;

class WorkApiController extends Controller
{
    private string $data;
    private WorkApiAction $works;
    public function __construct(WorkApiAction $works)
    {
        $this->middleware('auth');
        $this->works = $works;
    }

    public function work(): JsonResponse
    {
        $this->data = $this->works->getDataWork()->toJson();
        return response()->json($this->data);
    }
}
