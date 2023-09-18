<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\NewsAction;
use App\Models\Article;
use App\Requests\NewsRequest;
use Illuminate\Http\JsonResponse;

final class NewsApiController extends Controller
{
    /**
     * [add new article]
     */
    public function store(NewsRequest $request, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update article]
     */
    public function update(NewsRequest $request, Article $news, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->update($request->validated(null, null), $news);

        return $this->data;
    }

    /**
     * [delete article]
     */
    public function destroy(Article $news, NewsAction $newsAction): JsonResponse
    {
        $this->data = $newsAction->destroy($news);

        return $this->data;
    }
}
