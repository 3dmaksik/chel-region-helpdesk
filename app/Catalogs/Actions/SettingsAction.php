<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AccountDTO;
use App\Models\User;
use App\Requests\AccountRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsAction extends Action
{
    /**
     * [this user]
     */
    private User $user;

    /**
     * [this avatar]
     */
    private array $avatar;

    /**
     * [this sound notify]
     */
    private array $soundNotify;

    /**
     * [count role for user]
     */
    private int $countRole;

    /**
     * [clear data]
     */
    private array $dataClear;

    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * [update password]
     */
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

    /**
     * [check password]
     */
    protected function checkPassword(string $password): bool
    {
        if (Hash::check($password, auth()->user()->password)) {
            return true;
        }

        return false;
    }

    /**
     * [update settings]
     */
    public function updateSettings(AccountRequest $request): JsonResponse
    {
        $this->user = User::findOrFail(auth()->user()->id);
        $this->countRole = User::role(['superAdmin'])->count();
        $this->data = AccountDTO::storeObjectRequest($request);
        if ($this->user->getRoleNames()[0] === 'superAdmin' && $this->countRole === 1 && $this->data->role !== null) {
            return response()->error(['message' => 'Настройки не изменены! </br> Вы не можете отключить последнего администратора']);
        }
        if (isset($this->data->avatar)) {
            if ($this->user->avatar !== null) {
                Storage::disk('avatar')->delete($this->user->avatar);
            }
            $this->avatar = json_decode($this->data->avatar, true);
            $this->data->avatar = $this->avatar['url'];
        }
        if (isset($this->data->sound_notify)) {
            if ($this->user->sound_notify !== null) {
                Storage::disk('sound')->delete($this->user->sound_notify);
            }
            $this->soundNotify = json_decode($this->data->sound_notify, true);
            $this->data->sound_notify = $this->soundNotify['url'];
        }
        $this->dataClear = $this->clear($this->data);
        if (! empty($this->dataClear)) {
            $this->user->update($this->dataClear);
        }

        return response()->success('Настройки успешно обновлены');
    }

    /**
     * [clear data from bad data]
     */
    protected function clear(AccountDTO $data): array
    {
        return array_diff((array) $data, ['', null, 'null', false]);
    }
}
