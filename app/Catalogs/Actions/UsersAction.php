<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\Collections\RoleCollection;
use App\Http\Resources\UserResource;
use App\Models\Help;
use App\Models\User as Model;
use App\Requests\PasswordRequest;
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
     * [all users with count items max]
     *
     * @return array{data: mixed}
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
     *
     * @return array{roles: \Illuminate\Support\Collection}
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
     *
     * @return array{user: mixed, roles: \Illuminate\Support\Collection, role: mixed}
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
        $this->resource = new UserResource($request);
        $this->data = $this->resource->resolve();
        $this->data['password'] = Hash::make($this->data['password']);
        $this->data['email'] = mt_rand().time().'@1.ru';
        Model::create($this->data)->assignRole($this->data['role']);
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
        $this->countRole = Model::role(['superAdmin'])->count();
        $this->resource = new UserResource($request);
        $this->data = $this->resource->resolve();
        if ($this->user->getRoleNames()[0] === 'superAdmin' && $this->countRole === 1 && $this->data['role'] !== null) {
            return response()->error(['message' => 'Настройки не изменены! </br> Вы не можете отключить последнего администратора']);
        }
        $this->user->update($this->data);
        $this->user->syncRoles($this->data['role']);

        $this->response = [
            'message' => 'Пользователь успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(PasswordRequest $request, int $id): JsonResponse
    {
        $this->user = Model::findOrFail($id);
        $this->resource = new UserResource($request);
        $this->data = $this->resource->resolve();
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
        $this->count = Help::where('user_id', $id)->orWhere('executor_id', $id)->count();
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

        $this->response = [
            'message' => 'Пользователь успешно удалён!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
