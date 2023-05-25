<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\UsersDTO;
use App\Models\Help;
use App\Models\User as Model;
use App\Requests\UserPasswordRequest;
use App\Requests\UserRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as SimpleCollection;

class UsersAction extends Action
{
    private Model $user;

    private string $role;

    private SimpleCollection $roles;

    private SimpleCollection $cabinets;

    private array $users;

    private array $response;

    private int $count;

    private array $dataClear;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('lastname', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('lastname', 'ASC')->paginate($this->page);
        $this->users =
        [
            'data' => $this->items,
        ];

        return $this->users;
    }

    public function create(): array
    {
        $this->roles = AllCatalogsDTO::getAllRolesCollection();
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();

        return [
            'roles' => $this->roles,
            'cabinets' => $this->cabinets,
        ];
    }

    public function show(int $id): Model
    {
        $this->user = Model::findOrFail($id);

        return $this->user;
    }

    public function edit(int $id): array
    {
        $this->user = Model::findOrFail($id);
        $this->roles = AllCatalogsDTO::getAllRolesCollection();
        $this->role = $this->user->getRoleNames()[0];
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();

        return [
            'user' => $this->user,
            'roles' => $this->roles,
            'role' => $this->role,
            'cabinets' => $this->cabinets,
        ];
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        Model::create($this->dataClear)->assignRole($this->dataClear['role']);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Пользователь успешно добавлен!',
        ];

        return response()->success($this->response);
    }

    public function update(UserRequest $request, int $id): JsonResponse
    {
        $this->user = Model::findOrFail($id);
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        $this->user->update($this->dataClear);
        $this->user->syncRoles($this->dataClear['role']);
        Model::flushQueryCache();

        $this->response = [
            'message' => 'Пользователь успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    public function updatePassword(UserPasswordRequest $request, int $id): JsonResponse
    {
        $this->user = Model::findOrFail($id);
        $this->data = $request->validated();
        $this->user->update($this->data);
        if ($this->user->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Пользователь не может изменить пароль самому себе в данной форме!',
            ];

            return response()->error($this->response);
        }
        $this->response = [
            'message' => 'Пароль пользователя успешно изменён!',
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->count = Help::dontCache()->where('user_id', $id)->orWhere('executor_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Пользователь не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->user = Model::findOrFail($id);
        if ($this->user->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Пользователь не может удалить самого себя!',
            ];

            return response()->error($this->response);
        }
        $this->count = Model::role(['superAdmin'])->count();
        if ($this->count === 1) {
            $this->response = [
                'message' => 'Вы не можете удалить последнего администратора!',
            ];

            return response()->error($this->response);
        }
        $this->user->syncRoles([]);
        $this->user->forceDelete();
        Model::flushQueryCache();

        $this->response = [
            'message' => 'Пользователь успешно удалён!',
        ];

        return response()->success($this->response);
    }

    protected function clear(UsersDTO $data): array
    {
        return array_diff((array) $data, ['', null, 'null', false]);
    }
}
