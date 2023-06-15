<?php

namespace App\Catalogs\Collections;

use App\Base\Collections\Collection;
use Illuminate\Support\Collection as LaravelCollection;
use Spatie\Permission\Models\Role;

class RoleCollection extends Collection
{
    public static function getRoles(): LaravelCollection
    {
        return Role::orderBy('id', 'DESC')->get()->pluck('name');
    }
}
