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
    public function __construct(Category $category, Status $status, Cabinet $cabinet, Priority $priority, Work $work)
    {
        $this->category = $category;
        $this->status = $status;
        $this->cabinet = $cabinet;
        $this->priority = $priority;
        $this->work = $work;
    }
    //Преобразование объекта в любой вид данных для работы
    public function getAllCatalogsCollection(): Collection
    {
        return collect([
            'category' => $this->category->getAllItems(),
            'status' => $this->status->getAllItems(),
            'cabinet' => $this->cabinet->getAllItems(),
            'priority' => $this->priority->getAllItems(),
            'work' => $this->work->getAllItems(),
        ]);
    }
}
