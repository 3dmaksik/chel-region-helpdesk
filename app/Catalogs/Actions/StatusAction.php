<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\Status as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class StatusAction extends Action
{
    private array $statuses;

    private array $response;

    private int $count;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('description', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->statuses =
        [
            'data' => $this->items,
        ];

        return $this->statuses;
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    public function store(array $request): JsonResponse
    {
        $this->item = Model::create($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Статус успешно добавлен!',
        ];

        return response()->success($this->response);

    }

    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Статус успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->count = Help::dontCache()->where('status_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Статус не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Статус успешно удалён!',
        ];

        return response()->success($this->response);
    }
}
