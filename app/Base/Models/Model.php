<?php

namespace App\Base\Models;

use App\Core\Models\CoreModel;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Model extends CoreModel
{
    use QueryCacheable;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $timestamps = true;
    protected $cacheFor = 10080;
}
