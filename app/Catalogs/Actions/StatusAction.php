<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\StatusDTO;
use App\Core\Contracts\ICatalog;
use App\Models\Status as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class StatusAction extends Action implements ICatalog
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
        $this->item->save();
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
    public function update(array $request, int $id): JsonResponse
    {
        if (! $this->checkColor(config('color'), $request['color'])) {
            return response()->error(['message' => 'Статус не обновлён! </br> Неверно указан текущий цвет']);
        }
        $this->dataObject = new StatusDTO(
            $request['description'],
            $request['color']
        );
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Статус не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->description = $this->dataObject->description;
        $this->item->color = $this->dataObject->color;
        $this->item->save();
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
