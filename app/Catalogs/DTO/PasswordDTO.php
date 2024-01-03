<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

final class PasswordDTO extends DTO
{
    public readonly string $password;

    public readonly ?string $currentPassword;

    public function __construct(
        string $password,
        ?string $currentPassword = null
    ) {
        $this->password = $password;
        $this->currentPassword = $currentPassword;
    }
}
