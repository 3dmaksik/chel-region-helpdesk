<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\UsersDTO;
use App\Models\User;
use App\Requests\AccountRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsAction extends Action
{
    private User $user;

    private array $avatar;

    private array $soundNotify;

    private array $dataClear;

    private int $countRole;

    public function __construct()
    {
        //parent::__construct();
    }

    public function updatePassword(array $request): JsonResponse
    {
        if ($this->checkPassword($request['current_password']) === true && $this->checkPassword($request['password']) === false) {
            User::where('id', auth()->user()->id)->update([
                'password' => Hash::make($request['password']),
            ]);

            return response()->success(['message' => 'Пароль успешно обновлён!']);
        }

        return response()->error(['message' => 'Пароль не изменён! </br> Неверно указан текущий пароль']);
    }

    protected function checkPassword(string $password): bool
    {
        if (Hash::check($password, auth()->user()->password)) {
            return true;
        }

        return false;
    }

    public function editSettings(): User
    {
        $this->user = User::findOrFail(auth()->user()->id);
        if (isset($this->user->avatar)) {
            $this->avatar = json_decode($this->user->avatar, true);
            $this->user->avatar = $this->avatar['url'];
        }
        if (isset($this->user->sound_notify)) {
            $this->soundNotify = json_decode($this->user->sound_notify, true);
            $this->user->sound_notify = $this->soundNotify['url'];
        }

        return $this->user;
    }

    public function updateSettings(AccountRequest $request): JsonResponse
    {
        $this->user = User::findOrFail(auth()->user()->id);
        $this->countRole = User::role(['superAdmin'])->count();
        $this->data = UsersDTO::storeObjectRequest($request);
        if ($this->user->getRoleNames()[0] === 'superAdmin' && $this->countRole === 1 && $this->data->role !== null) {
            return response()->error(['message' => 'Настройки не изменены! </br> Вы не можете отключить последнего администратора']);
        }
        if (isset($this->data->avatar) && $this->user->avatar != null) {
            $this->user->avatar = json_decode($this->user->avatar, true);
            Storage::disk('avatar')->delete($this->user->avatar['url']);
        }
        if (isset($this->data->sound_notify) && $this->user->sound_notify != null) {
            $this->user->sound_notify = json_decode($this->user->sound_notify, true);
            Storage::disk('sound_notify')->delete($this->user->sound_notify['url']);
        }
        if ($this->data->avatar !== null) {
            $this->data->avatar = json_encode($this->data->avatar);
        }
        if ($this->data->sound_notify !== null) {
            $this->data->sound_notify = json_encode($this->data->sound_notify);
        }
        User::flushQueryCache();
        $this->dataClear = $this->clear($this->data);
        $this->user->update($this->dataClear);

        return response()->success('Настройки успешно обновлены');
    }

    protected function clear(UsersDTO $data): array
    {
        return array_diff((array) $data, ['', null, 'null', false]);
    }
}
