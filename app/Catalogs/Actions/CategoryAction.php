<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\CategoryDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Models\Category as Model;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class CategoryAction extends Action implements ICatalog, ICatalogExtented
{
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
        $this->items = Cache::tags('category')->remember('category.'.$this->currentPage, Carbon::now()->addDay(), function () {
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
     * [add new category]
     *
     * @param  array  $request {description: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new CategoryDTO(
            $request['description']
        );
        $this->item = new Model();
        $this->item->description = $this->dataObject->description;
        $this->item->save();
        $this->response = [
            'message' => 'Категория успешно добавлена в очередь на размещение!',
            'reload' => true,
        ];

        Cache::tags('category')->flush();

        return response()->success($this->response);

    }

    /**
     * [update category]
     *
     * @param  array  $request {description: string}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->dataObject = new CategoryDTO(
            $request['description']
        );
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Категория не найдена!',
            ];

            return response()->error($this->response);
        }
        $this->item->description = $this->dataObject->description;
        $this->item->save();
        $this->response = [
            'message' => 'Категория успешно добавлена в очередь на обновление!',
        ];

        Cache::tags('category')->flush();

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
            'message' => 'Категория успешно поставлена в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('category')->flush();

        return response()->success($this->response);
    }
}
