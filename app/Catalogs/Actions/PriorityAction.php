<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\Priority as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class PriorityAction extends Action
{
    /**
     * [result data]
     *
     * @var response [data => null|Illuminate\Pagination\LengthAwarePaginator,
     *                message => null|string,
     *                reload => null|bool]
     */
    private array $response;

    /**
     * [count help for priority]
     *
     * @var count
     */
    private int $count;

    /**
     * [all priority cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::remember('priority.'.$this->currentPage, Carbon::now()->addDay(), function () {
            return Model::query()->orderBy('description', 'ASC')->paginate($this->page);
        });

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
     *
     * @param  array  $request {description: string, rang: int, warning_timer: int, danger_timer: int}
     */
    public function store(array $request): JsonResponse
    {
        $this->item = Model::query()->create($request);
        $this->response = [
            'message' => 'Приоритет успешно добавлен!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update priority]
     *
     * @param  array  $request {description: string, rang: int, warning_timer: int, danger_timer: int}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Приоритет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->update($request);
        $this->response = [
            'message' => 'Приоритет успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete priority if there are no help]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->count = Help::where('priority_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Приоритет не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Приоритет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->forceDelete();
        $this->response = [
            'message' => 'Приоритет успешно удалён!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
