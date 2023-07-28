<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\CabinetDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Models\Cabinet as Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class CabinetAction extends Action implements ICatalog, ICatalogExtented
{
    /**
     * [count user for cabinet]
     *
     * @var countUser
     */
    private int $countUser;

    /**
     * [all cabinet cache with count items on page]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::tags('cabinet')->remember('cabinet.'.$this->currentPage, Carbon::now()->addDay(), function () {
            return Model::query()->orderBy('description', 'ASC')->paginate($this->page);
        });

        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one cabinet]
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
     * [add new cabinet]
     *
     * @param  array  $request {description: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new CabinetDTO(
            $request['description']
        );
        $this->item = new Model();
        $this->item->description = $this->dataObject->description;
        $this->item->save();
        $this->response = [
            'message' => 'Кабинет успешно добавлен в очередь на размещение!',
            'reload' => true,
        ];

        Cache::tags('cabinet')->flush();

        return response()->success($this->response);

    }

    /**
     * [update cabinet]
     *
     * @param  array  $request {description: string}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->dataObject = new CabinetDTO(
            $request['description']
        );
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Кабинет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->description = $this->dataObject->description;
        $this->item->save();
        $this->response = [
            'message' => 'Кабинет успешно добавлен в очередь на обновление!',
        ];

        Cache::tags('cabinet')->flush();

        return response()->success($this->response);
    }

    /**
     * [delete cabinet if there are no employees]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->countUser = User::query()->where('cabinet_id', $id)->count();

        if ($this->countUser > 0) {
            $this->response = [
                'message' => 'Кабинет не может быть удален, так как у кабинета есть сотрудники!',
            ];

            return response()->error($this->response);
        }
        $this->item = Model::query()->find($id);

        if (! $this->item) {
            $this->response = [
                'message' => 'Кабинет не найден!',
            ];

            return response()->error($this->response);
        }
        $this->item->forceDelete();
        $this->response = [
            'message' => 'Кабинет успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('cabinet')->flush();

        return response()->success($this->response);
    }
}
