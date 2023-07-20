<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Category as Model;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class CategoryAction extends Action
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
     * [count user for category]
     *
     * @var countUser
     */
    private int $countHelp;

    /**
     * [all category cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::remember('category.'.$this->currentPage, Carbon::now()->addDay(), function () {
            return Model::query()->orderBy('description', 'ASC')->paginate($this->page);
        });

        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one category]
     */
    public function show(int $id): Model
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Категория не найдена!',
            ];

            return response()->error($this->response);
        }

        return $this->item;
    }

    /**
     * [add new category]
     *
     * @param  array  $request {description: int}
     */
    public function store(array $request): JsonResponse
    {
        $this->item = Model::query()->create($request);
        $this->response = [
            'message' => 'Категория успешно добавлена!',
        ];

        return response()->success($this->response);

    }

    /**
     * [update category]
     *
     * @param  array  $request {description: int}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Категория не найдена!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->update($request);
        $this->response = [
            'message' => 'Категория успешно обновлёна!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete category if there are no help]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->countHelp = Help::where('category_id', $id)->count();
        if ($this->countHelp > 0) {
            $this->response = [
                'message' => 'Категория не может быть удалена, так как не удалены все заявки связанные с ней!',
                'reload' => true,
            ];

            return response()->error($this->response);
        }
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Категория не найдена!',
            ];

            return response()->error($this->response);
        }
        $this->item->query()->forceDelete();
        $this->response = [
            'message' => 'Категория успешно удалёна!',
        ];

        return response()->success($this->response);
    }
}
