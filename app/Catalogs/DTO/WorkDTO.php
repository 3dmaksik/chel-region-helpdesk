<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StringUserHelper;

class WorkDTO extends DTO
{
    public string $firstname;
    public string $lastname;
    public string $patronymic;
    public int $cabinet_id;
    public int $user_id;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->firstname = StringUserHelper::run($request['firstname']);
        $dto->lastname = StringUserHelper::run($request['lastname']);
        $dto->cabinet_id = $request['cabinet_id'];
        $dto->user_id = $request['user_id'];
        if (isset($request['patronymic'])) {
            $dto->patronymic = StringUserHelper::run($request['patronymic']);
        }
        return $dto;
    }
}
