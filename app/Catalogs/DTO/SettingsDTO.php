<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;

class SettingsDTO extends DTO
{

    public string $avatar;
    public string $sound_notify;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        if (isset($request['avatar'])) {
            $dto->avatar = json_encode(StoreFilesHelper::createOneFile($request['avatar'], 'avatar', 32, 32));
        }
        if (isset($request['sound_notify'])) {
            $dto->sound_notify = json_encode(StoreFilesHelper::createNotify($request['sound_notify'], 'sound'));
        }
        return $dto;
    }
}
