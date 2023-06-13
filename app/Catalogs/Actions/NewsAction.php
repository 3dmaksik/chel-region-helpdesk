<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Article as Model;
use Illuminate\Http\JsonResponse;

class NewsAction extends Action
{
    private array $news;

    private array $response;

    public function getAllPagesPaginate(): array
    {
        $this->item = new Model();
        $this->items = Model::dontCache()->orderBy('created_at', 'DESC')->paginate($this->page);
        $this->news =
        [
            'data' => $this->items,
        ];

        return $this->news;
    }

    public function findCatalogsById(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return $this->item;
    }

    public function show(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return $this->item;
    }

    public function store(array $request): JsonResponse
    {
        Model::create($request);
        $this->response = [
            'message' => 'Новость успешно добавлена!',
        ];

        return response()->success($this->response);
    }

    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Новость успешно обновлена!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Новость успешно удалена!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
