<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Hash;

class SettingsAction extends Action
{
    public function __construct()
    {
        //parent::__construct();
    }

    public function updatePassword(array $request) : bool
    {
        if ($this->checkPassword($request['current_password']) && ! $this->checkPassword($request['password'])) {
            return User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request['password']),
            ]);
        }
    }

    protected function checkPassword(string $password) : bool
    {
        if (! Hash::check($password, auth()->user()->password)) {
            return false;
        }
        return true;
    }

    public function editSettings(): array
    {
        $this->item = Work::select('avatar', 'sound_notify')->where('user_id', auth()->user()->id)->first();

        return [
            'avatar' => json_decode($this->item->avatar, true),
            'sound_notify' => json_decode($this->item->sound_notify, true),
            ];
    }

    public function updateSettings(array $request) : bool
    {
        return Work::whereId(auth()->user()->id)->update($request);
    }
}
