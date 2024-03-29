<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SearchCatalogAction;
use App\Requests\Search\SearchCabinetRequest;
use App\Requests\Search\SearchUserPublicRequest;
use App\Requests\Search\SearchUserRequest;
use Illuminate\Http\JsonResponse;

class SearchApiController extends Controller
{
    /**
     * [search cabinet for select2]
     */
    public function cabinet(SearchCabinetRequest $request, SearchCatalogAction $searchCatalogAction): JsonResponse
    {
        $this->data = $searchCatalogAction->searchUserCabinet($request->validated(null, null));

        return $this->data;
    }

    public function user(SearchUserRequest $request, SearchCatalogAction $searchCatalogAction): JsonResponse
    {
        $this->data = $searchCatalogAction->searchUserHelp($request->validated(null, null));

        return $this->data;
    }

    public function userPublic(SearchUserPublicRequest $request, SearchCatalogAction $searchCatalogAction): JsonResponse
    {
        $this->data = $searchCatalogAction->searchUserHelp($request->validated(null, null));

        return $this->data;
    }
}
