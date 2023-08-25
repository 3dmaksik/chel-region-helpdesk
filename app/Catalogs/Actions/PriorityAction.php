<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\StringHelper;
use App\Catalogs\DTO\PriorityDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Models\Help;
use App\Models\Priority as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class PriorityAction extends Action implements ICatalog, ICatalogExtented
{
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
        $this->items = Cache::tags('priority')->remember('priority.'.$this->currentPage, Carbon::now()->addDay(), function () {
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
    public function show(int $id): array
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        $this->response =
        [
            'data' => $this->item,
        ];

        return $this->response;
    }

    /**
     * [add new priority]
     *
     * @param  array  $request {description: string, rang: int, warning_timer: int, danger_timer: int}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new PriorityDTO(
            $request['description'],
            $request['rang'],
            $request['warning_timer'],
            $request['danger_timer']
        );
        $this->item = new Model();
        $this->item->description = StringHelper::run($this->dataObject->description);
        $this->item->rang = $this->dataObject->rang;
        $this->item->warning_timer = $this->dataObject->warning_timer;
        $this->item->danger_timer = $this->dataObject->danger_timer;
        $this->item->save();
        $this->response = [
            'message' => 'Приоритет успешно добавлен в очередь на размещение!',
            'reload' => true,
        ];

        Cache::tags('priority')->flush();

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

        $this->dataObject = new PriorityDTO(
            $request['description'],
            $request['rang'],
            $request['warning_timer'],
            $request['danger_timer']
        );
        $this->item->description = StringHelper::run($this->dataObject->description);
        $this->item->rang = $this->dataObject->rang;
        $this->item->warning_timer = $this->dataObject->warning_timer;
        $this->item->danger_timer = $this->dataObject->danger_timer;
        $this->item->save();

        $this->response = [
            'message' => 'Приоритет успешно добавлен в очередь на обновление!',
        ];

        Cache::tags('priority')->flush();

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
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Приоритет успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('priority')->flush();

        return response()->success($this->response);
    }
}
