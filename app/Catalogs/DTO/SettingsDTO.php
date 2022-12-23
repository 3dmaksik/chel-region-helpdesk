<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;

class SettingsDTO extends DTO
{

    public string $avatar;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        if (isset($request['avatar'])) {
            $dto->avatar = StoreFilesHelper::createFile($request['avatar'], 32, 32);
        }
        if (isset($request['sound_notify'])) {
            $dto->sound_notify = StoreFilesHelper::createNotify($request['sound_notify']);
        }
        $dto->work_id = $request['work_id'];
        return $dto;
    }
}
