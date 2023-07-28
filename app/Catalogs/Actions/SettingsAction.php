<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\StoreFilesHelper;
use App\Catalogs\DTO\AccountDTO;
use App\Catalogs\DTO\PasswordDTO;
use App\Core\Contracts\ISettings;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

final class SettingsAction extends Action implements ISettings
{
    /**
     * [this user]
     */
    private User $user;

    /**
     * [password data]
     */
    private PasswordDTO $passwordDTO;

    /**
     * [account data]
     */
    private AccountDTO $accountDTO;

    /**
     * [filename for upload]
     *
     * @var filenName
     */
    private string $fileName;

    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * [update password]
     *
     * @param  array  $request {current_password: string, password: string}
     */
    public function updatePassword(array $request): JsonResponse
    {
        $this->user = User::query()->find(auth()->user()->id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }
        $this->passwordDTO = new PasswordDTO(
            $request['password'],
            $request['current_password'],
        );
        if ($this->checkPassword($request['current_password']) === false && $this->checkPassword($request['password']) === true) {
            $this->response = [
                'message' => 'Пароль не изменён! </br> Неверно указан текущий пароль',
            ];

            return response()->error($this->response);
        }
        $this->user->password = Hash::make($this->passwordDTO->password);
        $this->user->save();

        $this->response = [
            'message' => 'Пароль успешно обновлён!',
        ];

        return response()->success($this->response);

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
    public function updateSettings(array $request): JsonResponse
    {
        $this->user = User::query()->find(auth()->user()->id);

        if (! $this->user) {
            $this->response = [
                'message' => 'Пользователь не найден!',
            ];

            return response()->error($this->response);
        }
        $this->accountDTO = new AccountDTO(
            $request['avatar'] ?? null,
            $request['sound_notify'] ?? null,
        );
        if ($this->accountDTO->avatar) {
            if ($this->user->avatar) {
                Storage::disk('avatar')->delete($this->user->avatar);
            }
            $this->fileName = StoreFilesHelper::createImageName();
            $this->user->avatar = $this->fileName;
            StoreFilesHelper::createOneImage($this->fileName, $this->accountDTO->avatar, 'avatar', 32, 32);
        }
        if ($this->accountDTO->soundNotify) {
            if ($this->user->sound_notify) {
                Storage::disk('sound')->delete($this->user->sound_notify);
            }
            $this->fileName = StoreFilesHelper::createSoundName();
            $this->user->sound_notify = $this->fileName;
            StoreFilesHelper::createNotify($this->fileName, $this->accountDTO->soundNotify, 'sound');
        }
        $this->user->save();
        $this->response = [
            'message' => 'Настройки успешно обновлены',
            'reload' => true,
        ];

        return response()->success($this->response);
    }
}
