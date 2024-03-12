<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Contracts\ICabinet;
use App\Catalogs\DTO\CabinetDTO;
use App\Models\Cabinet as Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class CabinetAction extends Action implements ICabinet
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
    public function show(Model $model): array
    {
        $this->response =
        [
            'data' => $model,
        ];

        return $this->response;
    }

    /**
     * [add new cabinet]
     *
     * @param  array  $request  {description: string}
     */
    public function store(array $request): JsonResponse
    {
        $this->dataObject = new CabinetDTO(
            $request['description']
        );
        $this->item = new Model();
        $this->item->description = $this->dataObject->description;
        DB::transaction(
            fn () => $this->item->save()
        );
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
     * @param  array  $request  {description: string}
     */
    public function update(array $request, Model $model): JsonResponse
    {
        $this->dataObject = new CabinetDTO(
            $request['description']
        );
        $model->description = $this->dataObject->description;
        DB::transaction(
            fn () => $model->save()
        );
        $this->response = [
            'message' => 'Кабинет успешно добавлен в очередь на обновление!',
        ];

        Cache::tags('cabinet')->flush();

        return response()->success($this->response);
    }

    /**
     * [delete cabinet if there are no employees]
     */
    public function destroy(Model $model): JsonResponse
    {
        $this->countUser = User::query()->where('cabinet_id', $model->id)->count();

        if ($this->countUser > 0) {
            $this->response = [
                'message' => 'Кабинет не может быть удален, так как у кабинета есть сотрудники!',
            ];

            return response()->error($this->response);
        }
        DB::transaction(
            fn () => $model->forceDelete()
        );
        $this->response = [
            'message' => 'Кабинет успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('cabinet')->flush();

        return response()->success($this->response);
    }
}
