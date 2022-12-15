<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class CoreModel extends LaravelModel
{
    abstract protected function setOrder(): Builder;
}
