<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\NewsAction;
use App\Requests\NewsRequest;
use Illuminate\Http\JsonResponse;

class NewsApiController extends Controller
{
    private JsonResponse $data;

    /**
     * [add new article]
     */
    public function store(NewsRequest $request, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->store($request->validated());

        return $this->data;
    }

    /**
     * [update article]
     */
    public function update(NewsRequest $request, int $news, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->update($request->validated(), $news);

        return $this->data;
    }

    /**
     * [delete article]
     */
    public function destroy(int $news, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->delete($news);

        return $this->data;
    }
}
