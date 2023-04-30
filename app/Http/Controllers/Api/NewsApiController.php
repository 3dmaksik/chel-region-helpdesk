<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\NewsAction;
use App\Requests\NewsRequest;
use Illuminate\Http\JsonResponse;

class NewsApiController extends Controller
{
    private JsonResponse $data;

    private NewsAction $news;

    public function __construct(NewsAction $news)
    {
        $this->news = $news;
    }

    public function store(NewsRequest $request): JsonResponse
    {
        $this->data = $this->news->store($request->validated());

        return $this->data;
    }

    public function update(NewsRequest $request, int $news): JsonResponse
    {
        $this->data = $this->news->update($request->validated(), $news);

        return $this->data;
    }

    public function destroy(int $news): JsonResponse
    {
        $this->data = $this->news->delete($news);

        return $this->data;
    }
}
