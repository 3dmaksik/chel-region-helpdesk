<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

final class CategoryDTO extends DTO
{
    public readonly string $description;

    public function __construct(
        string $description
    ) {
        $this->description = $description;
    }
}
