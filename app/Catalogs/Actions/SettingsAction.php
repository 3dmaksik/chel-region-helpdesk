<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\User;
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

    public function update(array $request) : bool
    {
        return User::whereId(auth()->user()->id)->update($request);
    }
}
