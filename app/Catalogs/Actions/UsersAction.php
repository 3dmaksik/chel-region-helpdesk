<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\StringUserHelper;
use App\Catalogs\DTO\PasswordDTO;
use App\Catalogs\DTO\UserDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Core\Contracts\IUser;
use App\Models\Help;
use App\Models\User as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

final class UsersAction extends Action implements ICatalog, ICatalogExtented, IUser
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
     * [count help for user]
     */
    private int $count;

    /**
     * [count role for user]
     */
    private int $countRole;

    /**
     * [password data]
     */
    private PasswordDTO $passwordDTO;

    /**
     * [all users with count items max]
     *
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->currentPage = request()->get('page', 1);
        $this->items = Cache::remember('users.'.$this->currentPage, Carbon::now()->addDay(), function () {
            return Model::query()->orderBy('lastname', 'ASC')->paginate($this->page);
        });

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
        $this->roles = $this->getRoles();

        return [
            'roles' => $this->roles,
        ];
    }

    /**
     * [show one user]
     */
    public function show(int $id): array
    {

        $this->user = Model::query()->find($id);
        if (! $this->user) {

            return abort(404);
        }
        $this->response =
        [
            'data' => $this->user,
        ];

        return $this->response;
    }

    /**
     * [edit user]
     *
     * @return array{user: \App\Models\User, roles: \Spatie\Permission\Models\Role, role: string}
     */
    public function edit(int $id): array
    {
        $this->user = Model::query()->find($id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }
        $this->roles = $this->getRoles();
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
    public function store(array $request): JsonResponse
    {
        if (! isset($request['password'])) {
            $this->response = [
                'message' => 'Пароль не задан!',
            ];

            return response()->error($this->response);
        }
        $this->passwordDTO = new PasswordDTO(
            $request['password']
        );
        $this->dataObject = new UserDTO(
            $request['name'],
            $request['firstname'],
            $request['lastname'],
            $request['cabinet_id'],
            $request['role'],
            $this->passwordDTO,
            $request['patronymic'],
        );
        $this->user = new Model();
        $this->user->name = $this->dataObject->name;
        $this->user->firstname = StringUserHelper::run($this->dataObject->firstname);
        $this->user->lastname = StringUserHelper::run($this->dataObject->lastname);
        $this->user->patronymic = StringUserHelper::run($this->dataObject->patronymic) ?? null;
        $this->user->cabinet_id = $this->dataObject->cabinetId;
        $this->user->password = Hash::make($this->dataObject->password);
        $this->user->email = mt_rand().time().'@1.ru';
        $this->user->save();
        $this->user->assignRole($this->dataObject->role);
        $this->response = [
            'message' => 'Пользователь успешно добавлен в очередь на размещение!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [update user]
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->user = Model::query()->find($id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }

        $this->dataObject = new UserDTO(
            $request['name'],
            $request['firstname'],
            $request['lastname'],
            $request['cabinet_id'],
            $request['role'],
            null,
            $request['patronymic'],
        );
        $this->countRole = Model::role(['superAdmin'])->count();
        if ($this->user->getRoleNames()[0] === 'superAdmin' && $this->countRole === 1 && $this->dataObject->role !== null) {
            return response()->error(['message' => 'Настройки не изменены! </br> Вы не можете отключить последнего администратора']);
        }
        $this->user->name = $this->dataObject->name;
        $this->user->firstname = StringUserHelper::run($this->dataObject->firstname);
        $this->user->lastname = StringUserHelper::run($this->dataObject->lastname);
        $this->user->patronymic = StringUserHelper::run($this->dataObject->patronymic) ?? $this->user->patronymic;
        $this->user->cabinet_id = $this->dataObject->cabinetId;
        $this->user->save();
        $this->user->syncRoles($this->dataObject->role);

        $this->response = [
            'message' => 'Пользователь успешно обновлён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(array $request, int $id): JsonResponse
    {
        $this->user = Model::query()->find($id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }
        $this->passwordDTO = new PasswordDTO(
            $request['password']
        );
        if ($this->user->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Пользователь не может изменить пароль самому себе в данной форме!',
            ];

            return response()->error($this->response);
        }
        $this->user->password = Hash::make($this->passwordDTO->password);
        $this->user->save();
        $this->response = [
            'message' => 'Пароль пользователя успешно изменён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete other user]
     */
    public function destroy(int $id): JsonResponse
    {
        $this->count = Help::where('user_id', $id)->orWhere('executor_id', $id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Пользователь не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }

        $this->user = Model::query()->find($id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }
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
            'message' => 'Пользователь успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [get all roles name]
     */
    private function getRoles(): Collection
    {
        return Role::query()->orderBy('id', 'DESC')->get()->pluck('name');
    }
}
