<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Help\Helpers\CheckHelpHelper;
use Illuminate\Http\JsonResponse;

class HelpApiController extends Controller
{
    private string $data;
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function all(AllCatalogsDTO $all): JsonResponse
    {
        $this->data = $all->getAllCatalogsCollection()->toJson();
        return response()->json($this->data);
    }

    public function checkHelp(int $id): JsonResponse
    {
        $this->data = CheckHelpHelper::checkUpdate($id);
        return response()->json($this->data);
    }
}
