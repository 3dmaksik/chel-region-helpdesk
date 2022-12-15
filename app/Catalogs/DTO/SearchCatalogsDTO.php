<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Models\Model;

class SearchCatalogsDTO extends DTO
{

    public Model $model;
    public int $id;
    public int $pages;
    public string $field;
    public static function searchCatalogsObjectRequest(Model $model, int $pages, int $id, string $field): self
    {
        $dto = new self();
        $dto->pages = $pages;
        $dto->id = $id;
        $dto->model = $model;
        $dto->field = $field;
        return $dto;
    }
}
