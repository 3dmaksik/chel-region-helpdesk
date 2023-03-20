<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersDTO extends DTO
{
    public string $name;
    public string $email;
    public string $password;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->name = $request['name'];
        $dto->email = Str::random(6).'@'.Str::random(4).'.ru';
        $dto->password = Hash::make($request['password']);
        return $dto;
    }
}
