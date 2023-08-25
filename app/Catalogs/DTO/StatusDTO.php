<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

final class StatusDTO extends DTO
{
    public readonly string $description;

    public readonly string $color;

    public function __construct(
        string $description,
        string $color
    ) {
        $this->description = $description;
        $this->color = $color;
    }
}
