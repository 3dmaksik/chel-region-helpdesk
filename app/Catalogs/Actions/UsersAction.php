<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\StringHelper;
use App\Catalogs\DTO\PasswordDTO;
use App\Catalogs\DTO\UserDTO;
use App\Base\Contracts\IUser;
use App\Models\Help;
use App\Models\User as Model;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

final class UsersAction extends Action implements IUser
{
    /**
     * [this user]
     *
     * @var user
     */
    private Model $user;

    /**
     * [collection roles]
     *
     * @var roles
     */
    private Collection $roles;

    /**
     * [one role]
     *
     * @var role
     */
    private string $role;

    /**
     * [count help for user]
     *
     * @var count
     */
    private int $count;

    /**
     * [count role for user]
     *
     * @var countRole
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
        $this->items = Cache::tags('user')->remember('users.'.$this->currentPage, Carbon::now()->addDay(), function () {
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
    public function show(Model $model): array
    {
        $this->response =
        [
            'data' => $model,
        ];

        return $this->response;
    }

    /**
     * [edit user]
     *
     * @return array{user: \App\Models\User, roles: \Spatie\Permission\Models\Role, role: string}
     */
    public function edit(Model $model): array
    {
        $this->roles = $this->getRoles();
        $this->role = $model->getRoleNames()[0];

        return [
            'user' => $model,
            'roles' => $this->roles,
            'role' => $this->role,
        ];
    }

    /**
     * [add new user]
     *
     * @param  array  $request  {name: string, firstname:string, cabinet_id: string, role: string, password: string, patronymic: string|null}
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
            (int) $request['cabinet_id'],
            $request['role'],
            $this->passwordDTO,
            $request['patronymic'],
        );
        $this->user = new Model();
        $this->user->name = $this->dataObject->name;
        $this->user->firstname = StringHelper::run($this->dataObject->firstname);
        $this->user->lastname = StringHelper::run($this->dataObject->lastname);
        $this->user->patronymic = StringHelper::run($this->dataObject->patronymic) ?? null;
        $this->user->cabinet_id = $this->dataObject->cabinetId;
        $this->user->password = Hash::make($this->dataObject->password);
        $this->user->email = mt_rand().time().'@1.ru';
        DB::transaction(
            fn () => $this->user->save()
        );
        $this->user->assignRole($this->dataObject->role);
        $this->response = [
            'message' => 'Пользователь успешно добавлен в очередь на размещение!',
            'reload' => true,
        ];

        Cache::tags('user')->flush();

        return response()->success($this->response);
    }

    /**
     * [update user]
     *
     * @param  array  $request  {name: string, firstname:string, cabinet_id: string, role: string, password: null, patronymic: string|null}
     */
    public function update(array $request, Model $model): JsonResponse
    {
        $this->dataObject = new UserDTO(
            $request['name'],
            $request['firstname'],
            $request['lastname'],
            (int) $request['cabinet_id'],
            $request['role'],
            null,
            $request['patronymic'],
        );
        $this->countRole = Model::role(['superAdmin'])->count();
        if ($model->getRoleNames()[0] === 'superAdmin' && $this->countRole === 1 && $this->dataObject->role !== null) {
            return response()->error(['message' => 'Настройки не изменены! </br> Вы не можете отключить последнего администратора']);
        }
        $model->name = $this->dataObject->name;
        $model->firstname = StringHelper::run($this->dataObject->firstname);
        $model->lastname = StringHelper::run($this->dataObject->lastname);
        $model->patronymic = StringHelper::run($this->dataObject->patronymic) ?? $model->patronymic;
        $model->cabinet_id = $this->dataObject->cabinetId;
        DB::transaction(
            fn () => $model->save()
        );
        $model->syncRoles($this->dataObject->role);

        $this->response = [
            'message' => 'Пользователь успешно обновлён!',
        ];

        Cache::tags('user')->flush();

        return response()->success($this->response);
    }

    /**
     * [update password for other user]
     *
     * @param  array  $request  {password: string}
     */
    public function updatePassword(array $request, Model $model): JsonResponse
    {
        $this->passwordDTO = new PasswordDTO(
            $request['password']
        );
        if ($model->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Пользователь не может изменить пароль самому себе в данной форме!',
            ];

            return response()->error($this->response);
        }
        $model->password = Hash::make($this->passwordDTO->password);
        $model->save();
        $this->response = [
            'message' => 'Пароль пользователя успешно изменён!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete other user]
     */
    public function destroy(Model $model): JsonResponse
    {
        $this->count = Help::where('user_id', $model->id)->orWhere('executor_id', $model->id)->count();
        if ($this->count > 0) {
            $this->response = [
                'message' => 'Пользователь не может быть удалён, так как не удалены все заявки связанные с ним!',
            ];

            return response()->error($this->response);
        }
        $this->role = $model->getRoleNames()[0];
        $this->countRole = Model::role(['superAdmin'])->count();
        if ($this->countRole === 1 && $this->role === 'superAdmin' || $model->id === auth()->user()->id) {
            $this->response = [
                'message' => 'Вы не можете удалить последнего администратора или себя!',
            ];

            return response()->error($this->response);
        }
        if ($model->avatar) {
            Storage::disk('avatar')->delete($model->avatar);
        }
        if ($model->sound_notify) {
            Storage::disk('sound')->delete($model->sound_notify);
        }
        $model->syncRoles([]);
        $model->forceDelete();

        $this->response = [
            'message' => 'Пользователь успешно поставлен в очередь на удаление!',
            'reload' => true,
        ];

        Cache::tags('user')->flush();

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
