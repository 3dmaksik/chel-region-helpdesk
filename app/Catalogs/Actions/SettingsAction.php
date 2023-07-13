<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Http\Resources\UserResource;
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
        $this->resource = new UserResource($request);
        $this->data = $this->resource->resolve();
        if (isset($this->data['avatar'])) {
            if ($this->user->avatar !== null) {
                Storage::disk('avatar')->delete($this->user->avatar);
            }
            $this->avatar = json_decode($this->data['avatar'], true, 512, JSON_THROW_ON_ERROR);
            $this->data['avatar'] = $this->avatar['url'];
        }
        if (isset($this->data['sound_notify'])) {
            if ($this->user->sound_notify !== null) {
                Storage::disk('sound')->delete($this->user->sound_notify);
            }
            $this->soundNotify = json_decode($this->data['sound_notify'], true, 512, JSON_THROW_ON_ERROR);
            $this->data['sound_notify'] = $this->soundNotify['url'];
        }
        if (! empty($this->data)) {
            $this->user->update($this->data);
        }

        return response()->success('Настройки успешно обновлены');
    }
}
