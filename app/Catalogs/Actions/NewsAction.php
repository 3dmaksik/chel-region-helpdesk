<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Article as Model;
use Illuminate\Http\JsonResponse;

class NewsAction extends Action
{
    /**
     * [result news]
     */
    private array $response;

    /**
     * @return array{data: mixed}
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('created_at', 'DESC')->paginate($this->page);
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one article]
     */
    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    /**
     * [add new article]
     */
    public function store(array $request): JsonResponse
    {
        Model::create($request);
        $this->response = [
            'message' => 'Новость успешно добавлена!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update article]
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        $this->response = [
            'message' => 'Новость успешно обновлена!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete article]
     */
    public function delete(int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Новость успешно удалена!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
