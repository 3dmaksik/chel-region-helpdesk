<?php

namespace App\Work\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StringWorkHelper;

class WorkDTO extends DTO
{
    public string $firstname;
    public string $lastname;
    public string $patronymic;
    public string $encrypt_description;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->firstname = StringWorkHelper::run($request['firstname']);
        $dto->lastname = StringWorkHelper::run($request['lastname']);
        if (isset($request['patronymic'])) {
            $dto->patronymic = StringWorkHelper::run($request['patronymic']);
        }
        $dto->encrypt_description = md5('metal' . $request['lastname'] . 'admin');
        return $dto;
    }
}
