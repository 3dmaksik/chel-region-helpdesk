<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Cabinet as Model;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CabinetAction extends Action
{
    /**
     * [result cabinet]
     */
    private array $response;

    /**
     * [count user for cabinet]
     */
    private int $countUser;

    /**
     * [all cabinet with count items on page]
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one cabinet]
     */
    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    /**
     * [add new cabinet]
     */
    public function store(array $request): JsonResponse
    {
        $this->item = Model::create($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Кабинет успешно добавлен!',
        ];

        return response()->success($this->response);

    }

    /**
     * [update cabinet]
     */
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

    /**
     * [delete cabinet if there are no employees]
     */
    public function delete(int $id): JsonResponse
    {
        $this->countUser = User::dontCache()->where('cabinet_id', $id)->count();
        if ($this->countUser > 0) {
            $this->response = [
                'message' => 'Кабинет не может быть удален, так как у кабинета есть сотрудники!',
            ];

            return response()->error($this->response);
        }
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Кабинет успешно удалён!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
