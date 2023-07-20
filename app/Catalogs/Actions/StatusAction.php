<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Status as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class StatusAction extends Action
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
     * [all status cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::remember('status.'.$this->currentPage, Carbon::now()->addDay(), function () {
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
    public function show(int $id): Model
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Статус не найден!',
            ];

            return response()->error($this->response);
        }

        return $this->item;
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
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Статус не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->update($request);
        $this->response = [
            'message' => 'Статус успешно обновлён!',
        ];

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
