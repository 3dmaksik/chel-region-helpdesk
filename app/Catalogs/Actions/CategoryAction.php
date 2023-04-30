<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Category as Model;
use App\Models\Help;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CategoryAction extends Action
{
    private array $categories;

    private array $response;

    private int $total;

    private int $count;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('description', 'ASC')->get($this->page);

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->item = new Model();
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->total = Model::count();
        $this->categories =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];

        return $this->categories;
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    public function store(array $request): JsonResponse
    {
        Model::create($request);
        $this->response = [
            'message' => 'Категория успешно добавлена!',
        ];

        return response()->success($this->response);
    }

    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Категория успешно обновлена!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->count = Help::dontCache()->where('category_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Категория не может быть удалена, так как не удалены все заявки связанные с ней!',
            ];

            return response()->error($this->response);
        }
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Категория успешно удалена!',
        ];

        return response()->success($this->response);
    }
}
