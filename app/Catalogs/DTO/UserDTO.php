<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

final class UserDTO extends DTO
{
    public readonly string $name;

    public readonly string $firstname;

    public readonly string $lastname;

    public readonly int $cabinetId;

    public readonly string $role;

    public readonly ?string $password;

    public readonly ?string $patronymic;

    public function __construct(
        string $name,
        string $firstname,
        string $lastname,
        int $cabinetId,
        string $role,
        ?PasswordDTO $password,
        string $patronymic = null,
    ) {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->cabinetId = $cabinetId;
        $this->role = $role;
        $this->password = $password?->password;
        $this->patronymic = $patronymic;
    }
}
