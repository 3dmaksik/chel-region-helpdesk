<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Status as Model;
use Illuminate\Http\JsonResponse;

class StatusAction extends Action
{
    /**
     * [result status]
     */
    private array $response;

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
     * [show one status]
     */
    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    /**
     * [update status for check existence color]
     */
    public function update(array $request, int $id): JsonResponse
    {
        if (! $this->checkColor(config('color'), $request['color'])) {
            return response()->error(['message' => 'Статус не обновлён! </br> Неверно указан текущий цвет']);
        }
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Статус успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [checking for the existence of a color in config]
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
