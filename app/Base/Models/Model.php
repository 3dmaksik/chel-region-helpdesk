<?php

namespace App\Base\Models;

use App\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Base\Models\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 *
 * @mixin \Eloquent
 */
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
