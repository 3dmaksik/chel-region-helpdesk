<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\StringHelper;
use App\Catalogs\DTO\PriorityDTO;
use App\Core\Contracts\IPriority;
use App\Models\Help;
use App\Models\Priority as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class PriorityAction extends Action implements IPriority
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
    public function show(Model $model): array
    {
        $this->response =
        [
            'data' => $model,
        ];

        return $this->response;
    }

    /**
     * [add new priority]
     *
     * @param  array  $request  {description: string, rang: int, warning_timer: int, danger_timer: int}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new PriorityDTO(
            $request['description'],
            (int) $request['rang'],
            (int) $request['warning_timer'],
            (int) $request['danger_timer']
        );
        $this->item = new Model();
        $this->item->description = StringHelper::run($this->dataObject->description);
        $this->item->rang = $this->dataObject->rang;
        $this->item->warning_timer = $this->dataObject->warning_timer;
        $this->item->danger_timer = $this->dataObject->danger_timer;
        DB::transaction(
            fn () => $this->item->save()
        );
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
     * @param  array  $request  {description: string, rang: int, warning_timer: int, danger_timer: int}
     */
    public function update(array $request, Model $model): JsonResponse
    {

        $this->dataObject = new PriorityDTO(
            $request['description'],
            (int) $request['rang'],
            (int) $request['warning_timer'],
            (int) $request['danger_timer']
        );
        $model->description = StringHelper::run($this->dataObject->description);
        $model->rang = $this->dataObject->rang;
        $model->warning_timer = $this->dataObject->warning_timer;
        $model->danger_timer = $this->dataObject->danger_timer;
        DB::transaction(
            fn () => $model->save()
        );

        $this->response = [
            'message' => 'Приоритет успешно добавлен в очередь на обновление!',
        ];

        Cache::tags('priority')->flush();

        return response()->success($this->response);
    }

    /**
     * [delete priority if there are no help]
     */
    public function destroy(Model $model): JsonResponse
    {
        $this->count = Help::where('priority_id', $model->id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Приоритет не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }
        DB::transaction(
            fn () => $model->forceDelete()
        );
        $this->response = [
            'message' => 'Приоритет успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('priority')->flush();

        return response()->success($this->response);
    }
}
