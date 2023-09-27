<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use App\Models\Category;
use App\Requests\CategoryRequest;
use Illuminate\Http\JsonResponse;

final class CategoryApiController extends Controller
{
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
    public function update(CategoryRequest $request, Category $category, CategoryAction $categoryAction): JsonResponse
    {
        $this->data = $categoryAction->update($request->validated(null, null), $category);

        return $this->data;
    }

    /**
     * [delete category]
     */
    public function destroy(Category $category, CategoryAction $categoryAction): JsonResponse
    {
        $this->data = $categoryAction->destroy($category);

        return $this->data;
    }
}
