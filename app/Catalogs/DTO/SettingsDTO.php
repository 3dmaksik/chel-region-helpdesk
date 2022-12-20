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
            $dto->avatar = json_encode(StoreFilesHelper::createFile($request['images'], 32, 32));
        }
        return $dto;
    }
}
