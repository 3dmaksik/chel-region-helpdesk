<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\Collections\RoleCollection;
use App\Catalogs\DTO\UsersDTO;
use App\Models\Help;
use App\Models\User as Model;
use App\Requests\UserPasswordRequest;
use App\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UsersAction extends Action
{
    /**
     * [this user]
     */
    private Model $user;

    /**
     * [collection roles]
     */
    private Collection $roles;

    /**
     * [one role]
     */
    private string $role;

    /**
     * [result users]
     */
    private array $response;

    /**
     * [count help for user]
     */
    private int $count;

    /**
     * [count role for user]
     */
    private int $countRole;

    /**
     * [clear data]
     */
    private array $dataClear;

    /**
     * [all users with count items max]
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('lastname', 'ASC')->paginate($this->page);
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [create new user]
     */
    public function create(): array
    {
        $this->roles = RoleCollection::getRoles();

        return [
            'roles' => $this->roles,
        ];
    }

    /**
     * [show one user]
     */
    public function show(int $id): Model
    {
        $this->user = Model::findOrFail($id);

        return $this->user;
    }

    /**
     * [edit user]
     */
    public function edit(int $id): array
    {
        $this->user = Model::findOrFail($id);
        $this->roles = RoleCollection::getRoles();
        $this->role = $this->user->getRoleNames()[0];

        return [
            'user' => $this->user,
            'roles' => $this->roles,
            'role' => $this->role,
        ];
    }

    /**
     * [add new user]
     */
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

    /**
     * [update user]
     */
    public function update(UserRequest $request, int $id): JsonResponse
    {
        $this->user = Model::findOrFail($id);
        $this->data = UsersDTO::storeObjectRequest($request);
        if ($this->data->password !== null) {
            $this->data->password = null;
        }
        $this->dataClear = $this->clear($this->data);
        $this->user->update($this->dataClear);
        $this->user->syncRoles($this->dataClear['role']);
        Model::flushQueryCache();

        $this->response = [
            'message' => 'Пользователь успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(UserPasswordRequest $request, int $id): JsonResponse
    {
        $this->user = Model::findOrFail($id);
        $this->data = $request->validated();
        if ($this->user->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Пользователь не может изменить пароль самому себе в данной форме!',
            ];

            return response()->error($this->response);
        }
        $this->user->update([
            'password' => Hash::make($this->data['password']),
        ]);
        $this->response = [
            'message' => 'Пароль пользователя успешно изменён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete other user]
     */
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
        $this->role = $this->user->getRoleNames()[0];
        $this->countRole = Model::role(['superAdmin'])->count();
        if ($this->countRole === 1 && $this->role === 'superAdmin' || $this->user->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Вы не можете удалить последнего администратора или себя!',
            ];

            return response()->error($this->response);
        }
        $this->user->syncRoles([]);
        $this->user->forceDelete();
        Model::flushQueryCache();

        $this->response = [
            'message' => 'Пользователь успешно удалён!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [clear data from bad data]
     */
    protected function clear(UsersDTO $data): array
    {
        return array_diff((array) $data, ['', null, 'null', false]);
    }
}
