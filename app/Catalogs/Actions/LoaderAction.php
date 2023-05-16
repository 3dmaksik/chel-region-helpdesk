<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class LoaderAction extends Action
{
    protected array $result;

    protected int $timer = 44640;

    public function __construct()
    {
        //parent::__construct();
        $this->result = [
            'avatar' => null,
            'soundNotify' => null,
        ];
        $this->removeCooke();
    }

    public function getLoad(): JsonResponse
    {
        if (auth()->user()->avatar !== null) {
            $this->result['avatar'] = json_decode(auth()->user()->avatar, true);
            $this->setCooke('avatar', $this->result['avatar']['url'], $this->timer);
        }
        if (auth()->user()->sound_notify !== null) {
            $this->result['soundNotify'] = json_decode(auth()->user()->sound_notify, true);
        }

        return response()->json($this->result);
    }

    protected function setCooke(string $name, string $url, int $timer)
    {
        return Cookie::queue($name, $url, $timer);
    }

    protected function removeCooke(): void
    {
        Cookie::forget('avatar');
        Cookie::forget('newCount');
    }
}
