<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Contracts\ICategory;
use App\Base\Helpers\StringHelper;
use App\Catalogs\DTO\CategoryDTO;
use App\Models\Category as Model;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class CategoryAction extends Action implements ICategory
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
    public function show(Model $model): array
    {
        $this->response =
        [
            'data' => $model,
        ];

        return $this->response;
    }

    /**
     * [add new category]
     *
     * @param  array  $request  {description: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new CategoryDTO(
            $request['description']
        );
        $this->item = new Model;
        $this->item->description = StringHelper::run($this->dataObject->description);
        DB::transaction(
            fn () => $this->item->save()
        );
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
     * @param  array  $request  {description: string}
     */
    public function update(array $request, Model $model): JsonResponse
    {
        $this->dataObject = new CategoryDTO(
            $request['description']
        );
        $model->description = StringHelper::run($this->dataObject->description);
        DB::transaction(
            fn () => $model->save()
        );
        $this->response = [
            'message' => 'Категория успешно добавлена в очередь на обновление!',
        ];

        Cache::tags('category')->flush();

        return response()->success($this->response);
    }

    /**
     * [delete category if there are no help]
     */
    public function destroy(Model $model): JsonResponse
    {
        $this->countHelp = Help::where('category_id', $model->id)->count();
        if ($this->countHelp > 0) {
            $this->response = [
                'message' => 'Категория не может быть удалена, так как не удалены все заявки связанные с ней!',
            ];

            return response()->error($this->response);
        }
        DB::transaction(
            fn () => $model->forceDelete()
        );
        $this->response = [
            'message' => 'Категория успешно поставлена в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('category')->flush();

        return response()->success($this->response);
    }
}
