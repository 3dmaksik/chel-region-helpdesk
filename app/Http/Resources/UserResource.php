<?php

namespace App\Http\Resources;

use App\Base\Helpers\StoreFilesHelper;
use App\Base\Helpers\StringUserHelper;
use App\Base\Resources\Resource;
use Illuminate\Http\Request;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->removeNullValues([
            'name' => $this->name,
            'password' => $this->password ?? null,
            'firstname' => StringUserHelper::run($this->firstname),
            'lastname' => StringUserHelper::run($this->lastname),
            'patronymic' => StringUserHelper::run($this->patronymic),
            'cabinet_id' => $this->cabinet_id,
            'avatar' => StoreFilesHelper::createOneImage($request->file('avatar'), 'avatar', 32, 32),
            'sound_notify' => StoreFilesHelper::createNotify($request->file('sound_notify'), 'sound'),
            'role' => $this->role,
        ]);
    }
}
