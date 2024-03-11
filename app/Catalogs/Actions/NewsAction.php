<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Contracts\IArticle;
use App\Catalogs\DTO\ArticleDTO;
use App\Models\Article as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class NewsAction extends Action implements IArticle
{
    /**
     * [all news cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::tags('article')->remember('article.'.$this->currentPage, 30, function () {
            return Model::orderBy('created_at', 'DESC')->paginate($this->page);
        });
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one article]
     */
    public function show(Model $model): array
    {
        $this->response =
        [
            'data' => $model,
        ];

        return $this->response;
    }

    /**
     * [add new article]
     *
     * @param  array  $request  {name: string, description: string, news_text: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new ArticleDTO(
            $request['name'],
            $request['description'],
            $request['news_text']
        );
        $this->item = new Model();
        $this->item->name = $this->dataObject->name;
        $this->item->description = $this->dataObject->description;
        $this->item->news_text = $this->dataObject->newsText;
        DB::transaction(
            fn () => $this->item->save()
        );
        $this->response = [
            'message' => 'Новость успешно добавлена в очередь на размещение!',
            'reload' => true,
        ];

        Cache::tags('article')->flush();

        return response()->success($this->response);

    }

    /**
     * [update article]
     *
     * @param  array  $request  {name: string, description: string, news_text: string, created_at: date}
     */
    public function update(array $request, Model $model): JsonResponse
    {
        $this->dataObject = new ArticleDTO(
            $request['name'],
            $request['description'],
            $request['news_text'],
            new Carbon($request['created_at']),
        );
        $model->name = $this->dataObject->name;
        $model->description = $this->dataObject->description;
        $model->news_text = $this->dataObject->newsText;
        $model->created_at = $this->dataObject->createdAt;
        DB::transaction(
            fn () => $model->save()
        );
        $this->response = [
            'message' => 'Новость успешно добавлена в очередь на обновление!',
        ];

        Cache::tags('article')->flush();

        return response()->success($this->response);
    }

    /**
     * [delete article]
     */
    public function destroy(Model $model): JsonResponse
    {
        DB::transaction(
            fn () => $model->forceDelete()
        );
        $this->response = [
            'message' => 'Новость успешно поставлена в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('article')->flush();

        return response()->success($this->response);
    }
}
