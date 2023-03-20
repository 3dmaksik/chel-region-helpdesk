<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class AllCatalogsDTO extends DTO
{
    //Преобразование объекта в любой вид данных для работы
    public static function getAllCatalogsCollection(): Collection
    {
        return collect([
            'category' => Category::get(),
            'status' => Status::get(),
            'cabinet' => Cabinet::get(),
            'priority' => Priority::get(),
            'user' => User::get(),
        ]);
    }

    public static function getAllRolesCollection(): Collection
    {
        return collect(Role::all()->pluck('name'));
    }

    public static function getAllCategoryCollection(): Collection
    {
        return collect(Category::get());
    }

    public static function getAllStatusCollection(): Collection
    {
        return collect(Status::get());
    }

    public static function getAllCabinetCollection(): Collection
    {
        return collect(Cabinet::get());
    }

    public static function getAllPriorityCollection(): Collection
    {
        return collect(Priority::get());
    }

    public static function getAllUserCollection(): Collection
    {
        return collect(User::get());
    }
}
