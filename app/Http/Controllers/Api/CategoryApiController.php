<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use App\Requests\CategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    /**
     * [result data]
     */
    private JsonResponse $data;

    /**
     * [add new category]
     */
    public function store(CategoryRequest $request, CategoryAction $categoryAction): JsonResponse
    {
        $this->data = $categoryAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update category]
     */
    public function update(CategoryRequest $request, int $category, CategoryAction $categoryAction): JsonResponse
    {
        $this->data = $categoryAction->update($request->validated(null, null), $category);

        return $this->data;
    }

    /**
     * [delete category]
     */
    public function destroy(int $category, CategoryAction $categoryAction): JsonResponse
    {
        $this->data = $categoryAction->destroy($category);

        return $this->data;
    }
}
