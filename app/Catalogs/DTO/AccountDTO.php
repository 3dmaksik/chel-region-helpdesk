<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;
use App\Base\Requests\Request;

class AccountDTO extends DTO
{
    public ?string $role;

    public ?string $avatar;

    public ?string $sound_notify;

    public static function storeObjectRequest(Request $request): self
    {
        $dto = new self();
        $dto->avatar = StoreFilesHelper::createOneFile($request->file('avatar'), 'avatar', 32, 32);
        $dto->sound_notify = StoreFilesHelper::createNotify($request->file('sound_notify'), 'sound');
        $dto->role = $request->get('role');

        return $dto;
    }
}
