<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;

class LoaderAction extends Action
{
    protected array $result;
    protected int $timer = 525600;

    public function __construct()
    {
        //parent::__construct();
        $this->result = [
            'avatar' => null,
            'soundNotify' => null,
        ];
    }

    public function getLoad(): array
    {
        if (auth()->user()->avatar != null) {
            $this->result['avatar'] = json_decode(auth()->user()->avatar, true);
        }
        if (auth()->user()->sound_notify != null) {
            $this->result['soundNotify'] = json_decode(auth()->user()->sound_notify, true);
        }
        return $this->result;
    }
}
