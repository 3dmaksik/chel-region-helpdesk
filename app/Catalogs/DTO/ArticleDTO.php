<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use Carbon\Carbon;

final class ArticleDTO extends DTO
{
    public readonly string $name;

    public readonly string $description;

    public readonly string $newsText;

    public readonly ?Carbon $createdAt;

    public function __construct(
        string $name,
        string $description,
        string $newsText,
        ?Carbon $createdAt = null,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->newsText = $newsText;
        $this->createdAt = $createdAt;
    }
}
