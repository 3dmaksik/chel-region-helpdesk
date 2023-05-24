<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\Priority as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class PriorityAction extends Action
{
    private array $proirity;

    private array $response;

    private int $count;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('rang', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->item = new Model();
        $this->items = Model::orderBy('rang', 'ASC')->paginate($this->page);
        $this->proirity =
        [
            'data' => $this->items,
        ];

        return $this->proirity;
    }

    public function findCatalogsById(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
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
            'message' => 'Приоритет успешно добавлен!',
        ];

        return response()->success($this->response);
    }

    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Приоритет успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->count = Help::dontCache()->where('priority_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Приоритет не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Приоритет успешно удалён!',
        ];

        return response()->success($this->response);
    }
}
