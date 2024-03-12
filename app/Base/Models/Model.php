<?php

namespace App\Base\Models;

use App\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends CoreModel
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
