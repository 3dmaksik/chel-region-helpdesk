<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\SettingsDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingsAction extends Action
{
    private User $user;

    private array $avatar;

    private array $soundNotify;

    public function __construct()
    {
        //parent::__construct();
    }

    public function updatePassword(array $request): bool
    {
        if ($this->checkPassword($request['current_password']) === true && $this->checkPassword($request['password']) === false) {
            return User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request['password']),
            ]);
        }

        return false;
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
        $this->user = User::whereId(auth()->user()->id)->first();
        if (isset($this->user->avatar)){
            $this->avatar = json_decode($this->user->avatar, true);
            $this->user->avatar = $this->avatar['url'];
        }
        if (isset($this->user->sound_notify)){
            $this->soundNotify = json_decode($this->user->sound_notify, true);
            $this->user->sound_notify = $this->soundNotify['url'];
        }

        return $this->user;
    }

    public function updateSettings(array $request): bool
    {
        $this->user = User::whereId(auth()->user()->id)->first();
        $this->data = SettingsDTO::storeObjectRequest($request);
        if (isset($this->data->avatar) && $this->user->avatar != null) {
            $this->user->avatar = json_decode($this->user->avatar, true);
            unlink(storage_path('app\\public\\avatar\\'.$this->user->avatar['url']));
        }
        if (isset($this->data->sound_notify) && $this->user->sound_notify != null) {
            $this->user->sound_notify = json_decode($this->user->sound_notify, true);
            unlink(storage_path('app\\public\\sound\\'.$this->user->sound_notify['url']));
        }
        User::flushQueryCache();
        $this->user->update((array) $this->data);

        return true;
    }
}
