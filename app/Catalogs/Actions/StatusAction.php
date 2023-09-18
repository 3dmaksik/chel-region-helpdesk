<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\StatusDTO;
use App\Core\Contracts\IStatus;
use App\Models\Status as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class StatusAction extends Action implements IStatus
{
    /**
     * [all status cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::tags('status')->remember('status.'.$this->currentPage, Carbon::now()->addDay(), function () {
            return Model::query()->orderBy('description', 'ASC')->paginate($this->page);
        });

        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one status]
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
     * [add new status]
     *
     * @param  array  $request {description: string, color: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new StatusDTO(
            $request['description'],
            $request['color']
        );
        $this->item = new Model();
        $this->item->description = $this->dataObject->description;
        $this->item->color = $this->dataObject->color;
        DB::transaction(
            fn () => $this->item->save()
        );
        $this->response = [
            'message' => 'Статус не может быть добавлен, так как все статусы уже созданы!',
            'reload' => true,
        ];

        return response()->success($this->response);

    }

    /**
     * [update status for check existence color]
     *
     * @param  array  $request {description: string, color: string}
     */
    public function update(array $request, Model $model): JsonResponse
    {
        if (! $this->checkColor(config('color'), $request['color'])) {
            return response()->error(['message' => 'Статус не обновлён! </br> Неверно указан текущий цвет']);
        }
        $this->dataObject = new StatusDTO(
            $request['description'],
            $request['color']
        );
        $model->description = $this->dataObject->description;
        $model->color = $this->dataObject->color;
        DB::transaction(
            fn () => $model->save()
        );
        $this->response = [
            'message' => 'Статус успешно добавлен в очередь на обновление!',
        ];

        Cache::tags('status')->flush();

        return response()->success($this->response);
    }

    /**
     * [checking for the existence of a color in config]
     *
     * @param  array  $color {name: string, slug: string}
     */
    private function checkColor(array $color, string $check, bool $status = false): bool
    {
        foreach ($color as $oneColor) {
            if ($oneColor['slug'] === $check) {
                $status = true;
                break;
            }
        }

        return $status;
    }
}
