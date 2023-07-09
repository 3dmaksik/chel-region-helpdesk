<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\Priority as Model;
use Illuminate\Http\JsonResponse;

class PriorityAction extends Action
{
    /**
     * [result priority]
     */
    private array $response;

    /**
     * [count help for priority]
     */
    private int $count;

    /**
     * [all priority with count items max]
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('rang', 'ASC')->paginate(10);
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one priority]
     */
    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    /**
     * [add new priority]
     */
    public function store(array $request): JsonResponse
    {
        Model::create($request);
        $this->response = [
            'message' => 'Приоритет успешно добавлен!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update priority]
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        $this->response = [
            'message' => 'Приоритет успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete priority if there are no help]
     */
    public function delete(int $id): JsonResponse
    {
        $this->count = Help::where('priority_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Приоритет не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Приоритет успешно удалён!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
