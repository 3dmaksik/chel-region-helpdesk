<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Core\Contracts\ICabinet;
use App\Models\Cabinet as Model;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class CabinetAction extends Action implements ICabinet
{
    /**
     * [result cabinet]
     *
     * @var response [data => null|Illuminate\Pagination\LengthAwarePaginator,
     *                message => null|string,
     *                route => null|string,
     *                reload => null|bool]
     */
    private array $response;

    /**
     * [count user for cabinet]
     *
     * @var countUser
     */
    private int $countUser;

    /**
     * [all cabinet with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::query()->orderBy('description', 'ASC')->paginate($this->page);
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
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Кабинет не найден!',
            ];

            return response()->error($this->response);
        }

        return $this->item;
    }

    /**
     * [add new cabinet]
     *
     * @param array $request {description: int}
     */
    public function store(array $request): JsonResponse
    {
        $this->item = Model::query()->create($request);
        $this->response = [
            'message' => 'Кабинет успешно добавлен!',
        ];

        return response()->success($this->response);

    }

    /**
     * [update cabinet]
     *
     * @param array $request {description: int}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Кабинет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->update($request);
        $this->response = [
            'message' => 'Кабинет успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete cabinet if there are no employees]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->countUser = User::query()->where('cabinet_id', $id)->count();

        if ($this->countUser > 0) {
            $this->response = [
                'message' => 'Кабинет не может быть удален, так как у кабинета есть сотрудники!',
            ];

            return response()->error($this->response);
        }
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Кабинет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->forceDelete();
        $this->response = [
            'message' => 'Кабинет успешно удалён!',
            'route' => route('cabinet.getIndex'),
        ];

        return response()->success($this->response);
    }
}
