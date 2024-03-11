<?php

namespace App\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Model extends LaravelModel
{
    use HasFactory;

    final public const CREATED_AT = 'created_at';

    final public const UPDATED_AT = 'updated_at';

    public $timestamps = true;

    public function resolveRouteBinding($value, $field = null): Model
    {
        return $this->resolveRouteBindingQuery($this, $value, $field)->firstOrFail();
    }
}
