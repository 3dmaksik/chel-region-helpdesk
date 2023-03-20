<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StringUserHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersDTO extends DTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $firstname;
    public string $lastname;
    public string $patronymic;
    public int $cabinet_id;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->name = $request['name'];
        $dto->email = Str::random(6).'@'.Str::random(4).'.ru';
        $dto->password = Hash::make($request['password']);
        $dto->firstname = StringUserHelper::run($request['firstname']);
        $dto->lastname = StringUserHelper::run($request['lastname']);
        $dto->cabinet_id = $request['cabinet_id'];
        if (isset($request['patronymic'])) {
            $dto->patronymic = StringUserHelper::run($request['patronymic']);
        }
        return $dto;
    }
}
