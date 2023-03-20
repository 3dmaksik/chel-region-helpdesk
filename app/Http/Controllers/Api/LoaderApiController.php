<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\LoaderAction;
use Illuminate\Http\JsonResponse;

class LoaderApiController extends Controller
{
    private array $data;
    private LoaderAction $loader;

    public function __construct(LoaderAction $loader)
    {
        $this->loader = $loader;
    }

    public function index(): JsonResponse
    {
        $this->data = $this->loader->getLoad();
        return response()->json($this->data);
    }
}
