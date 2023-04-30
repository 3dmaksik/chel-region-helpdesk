<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Cabinet as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CabinetAction extends Action
{
    private array $cabinets;

    private array $response;

    private int $total;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('description', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->total = Model::count();
        $this->cabinets =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];

        return $this->cabinets;
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
            'message' => 'Кабинет успешно добавлен!',
        ];

        return response()->success($this->response);

    }

    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Кабинет успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        Model::flushQueryCache();
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Кабинет успешно удалён!',
        ];

        return response()->success($this->response);
    }
}
