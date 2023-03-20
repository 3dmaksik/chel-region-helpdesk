<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class LoaderAction extends Action
{
    protected User $user;
    protected array $result;
    protected int $timer = 525600;

    public function __construct()
    {
        //parent::__construct();
        $this->result = [
            'firstname' => null,
            'avatar' => null,
            'soundNotify' => null,
        ];
    }

    public function getLoad(): array
    {
        $this->user = User::select('firstname', 'avatar', 'sound_notify')->where('id', auth()->user()->id)->first();
        $this->result['firstname'] = $this->user->firstname;

        if ($this->user->avatar != null) {
            $this->result['avatar'] = json_decode($this->user->avatar, true);
        }
        if ($this->user->soundNotify != null) {
            $this->result['soundNotify'] = json_decode($this->user->soundNotify, true);
        }

        $this->setCookie($this->result);
        return $this->result;
    }

    protected function setCookie(array $data) : void
    {
        Cookie::queue('firstname', $data['firstname'], $this->timer);
    }
}
