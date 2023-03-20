<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\SettingsDTO;
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

    public function editSettings(): Work
    {
        $this->item = Work::select('user_id', 'avatar', 'sound_notify')->where('user_id', auth()->user()->id)->first();
        $this->item->avatar = json_decode($this->item->avatar, true);
        $this->item->sound_notify = json_decode($this->item->sound_notify, true);
        return $this->item;
    }

    public function updateSettings(array $request) : bool
    {
        $this->item = Work::select('user_id', 'avatar', 'sound_notify')->where('user_id', auth()->user()->id)->first();
        $this->data = SettingsDTO::storeObjectRequest($request);
        if ($this->item->avatar != null) {
            $this->item->avatar = json_decode($this->item->avatar, true);
            unlink(storage_path('app\\public\\'.$this->item->avatar['url']));
        }
        if ($this->item->sound_notify != null) {
            $this->item->sound_notify = json_decode($this->item->sound_notify, true);
            unlink(storage_path('app\\public\\'.$this->item->sound_notify['url']));
        }
        Work::flushQueryCache();
        return Work::whereId(auth()->user()->id)->update((array) $this->data);
    }
}
