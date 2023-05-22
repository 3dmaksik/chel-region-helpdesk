<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;
use App\Base\Helpers\StringUserHelper;
use App\Base\Requests\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersDTO extends DTO
{
    public ?string $name;

    public ?string $email;

    public ?string $password;

    public ?string $firstname;

    public ?string $lastname;

    public ?string $patronymic;

    public ?string $role;

    public ?int $cabinet_id;

    public ?string $avatar;

    public ?string $sound_notify;

    public static function storeObjectRequest(Request $request): self
    {
        $dto = new self();
        $dto->name = $request->get('name');
        $dto->email = Str::random(6).'@'.Str::random(4).'.ru';
        $dto->password = Hash::make($request->get('password'));
        $dto->firstname = StringUserHelper::run($request->get('firstname'));
        $dto->lastname = StringUserHelper::run($request->get('lastname'));
        $dto->cabinet_id = $request->get('cabinet_id');
        $dto->patronymic = StringUserHelper::run($request->get('patronymic'));
        $dto->role = $request->get('role');
        $dto->avatar = StoreFilesHelper::createOneFile($request->file('avatar'), 'avatar', 32, 32);
        $dto->sound_notify = StoreFilesHelper::createNotify($request->get('sound_notify'), 'sound');

        return $dto;
    }
}
