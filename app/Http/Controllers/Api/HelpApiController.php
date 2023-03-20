<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\Api\HelpApiAction;
use Illuminate\Http\JsonResponse;

class HelpApiController extends Controller
{
    private string $data;
    private HelpApiAction $helps;
    public function __construct(HelpApiAction $helps)
    {
        $this->middleware('auth');
        $this->helps = $helps;
    }

    public function getAllPages(): JsonResponse
    {
        $this->data = $this->helps->getAllCatalogs()->toJson();
        return response()->json($this->data);
    }

    public function checkHelp(int $id): JsonResponse
    {
        $this->data = $this->helps->updateView($id);
        return response()->json($this->data);
    }

    public function newPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNewPagesCount();
        return response()->json($this->data);
    }

    public function nowPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNowPagesCount();
        return response()->json($this->data);
    }

   /* public function getSoundNotify(): JsonResponse
    {
        $this->data = '/sound/sound.ogg';
        return response()->json($this->data);
    }
    */
}
