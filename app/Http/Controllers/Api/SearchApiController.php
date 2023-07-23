<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SearchCatalogAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    /**
     * [search cabinet for select2]
     */
    public function cabinet(Request $request, SearchCatalogAction $searchCatalogAction): JsonResponse
    {
        $this->data = $searchCatalogAction->searchUserCabinet($request->get('q'));

        return $this->data;
    }
}
