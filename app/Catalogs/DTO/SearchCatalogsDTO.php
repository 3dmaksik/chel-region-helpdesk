<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;

class SearchCatalogsDTO extends DTO
{

    public int $id;
    public string $field;
    public static function searchWorkObjectRequest(int $id): self
    {
        $dto = new self();
        $dto->field = 'work_id';
        $dto->id = $id;
        return $dto;
    }

    public static function searchCategoryObjectRequest(int $id): self
    {
        $dto = new self();
        $dto->field = 'category_id';
        $dto->id = $id;
        return $dto;
    }

    public static function searchCabinetObjectRequest(int $id): self
    {
        $dto = new self();
        $dto->field = 'cabinet_id';
        $dto->id = $id;
        return $dto;
    }
}
