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
     * [edit settings]
     */
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
        if (isset($this->data->avatar) && $this->user->avatar != null) {
            $this->user->avatar = json_decode($this->user->avatar, true);
            Storage::disk('avatar')->delete($this->user->avatar['url']);
        }
        if (isset($this->data->sound_notify) && $this->user->sound_notify != null) {
            $this->user->sound_notify = json_decode($this->user->sound_notify, true);
            Storage::disk('sound')->delete($this->user->sound_notify['url']);
        }
        User::flushQueryCache();
        $this->dataClear = $this->clear($this->data);
        $this->user->update($this->dataClear);

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
