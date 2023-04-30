<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use App\Requests\CategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    private JsonResponse $data;

    private CategoryAction $categories;

    public function __construct(CategoryAction $categories)
    {
        $this->categories = $categories;
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $this->data = $this->categories->store($request->validated());

        return $this->data;
    }

    public function update(CategoryRequest $request, int $cabinet): JsonResponse
    {
        $this->data = $this->categories->update($request->validated(), $cabinet);

        return $this->data;
    }

    public function destroy(int $cabinet): JsonResponse
    {
        $this->data = $this->categories->delete($cabinet);

        return $this->data;
    }
}
