<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Work;
use Illuminate\Support\Collection;

class AllCatalogsDTO extends DTO
{
    public Category $category;
    public Status $status;
    public Cabinet $cabinet;
    public Priority $priority;
    public Work $work;
    //Преобразование объекта в любой вид данных для работы
    public static function getAllCatalogsCollection(): Collection
    {
        $category = new Category();
        $status = new Status();
        $cabinet = new Cabinet();
        $priority = new Priority();
        $work = new Work();
        return collect([
            'category' => $category->getAllItems(),
            'status' => $status->getAllItems(),
            'cabinet' => $cabinet->getAllItems(),
            'priority' => $priority->getAllItems(),
            'work' => $work->getAllItems(),
        ]);
    }
}
