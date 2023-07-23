<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

final class PriorityDTO extends DTO
{
    public readonly string $description;

    public readonly int $rang;

    public readonly int $warning_timer;

    public readonly int $danger_timer;

    public function __construct(
        string $description,
        int $rang,
        int $warning_timer,
        int $danger_timer,
    ) {
        $this->description = $description;
        $this->rang = $rang;
        $this->warning_timer = $warning_timer;
        $this->danger_timer = $danger_timer;
    }
}
