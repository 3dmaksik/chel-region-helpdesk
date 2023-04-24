<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;
use App\Base\Requests\Request;

class SettingsDTO extends DTO
{
    public ?string $avatar;

    public ?string $sound_notify;

    public static function storeObjectRequest(Request $request): self
    {
        $dto = new self();
        $dto->avatar = json_encode(StoreFilesHelper::createOneFile($request->get('avatar'), 'avatar', 32, 32));
        $dto->sound_notify = json_encode(StoreFilesHelper::createNotify($request->get('sound_notify'), 'sound'));

        return $dto;
    }
}
