<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\ArticleDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Models\Article as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class NewsAction extends Action implements ICatalog, ICatalogExtented
{
    /**
     * [all news cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::remember('article.'.$this->currentPage, 30, function () {
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
    public function show(int $id): array
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        $this->response =
        [
            'data' => $this->item,
        ];

        return $this->response;
    }

    /**
     * [add new article]
     *
     * @param  array  $request {name: string, description: string, news_text: string}
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
        $this->item->save();
        $this->response = [
            'message' => 'Новость успешно добавлена в очередь на размещение!',
            'reload' => true,
        ];

        return response()->success($this->response);

    }

    /**
     * [update article]
     *
     * @param  array  $request {name: string, description: string, news_text: string, created_at: date}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->dataObject = new ArticleDTO(
            $request['name'],
            $request['description'],
            $request['news_text'],
            new Carbon($request['created_at']),
        );
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Новость не найдена!',
            ];

            return response()->error($this->response);
        }
        $this->item->name = $this->dataObject->name;
        $this->item->description = $this->dataObject->description;
        $this->item->news_text = $this->dataObject->newsText;
        $this->item->created_at = $this->dataObject->createdAt;
        $this->item->save();
        $this->response = [
            'message' => 'Новость успешно добавлена в очередь на обновление!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete article]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Новость не найдена!',
            ];

            return response()->error($this->response);
        }
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Новость успешно поставлена в очередь на удаление!',
        ];

        return response()->success($this->response);
    }
}
