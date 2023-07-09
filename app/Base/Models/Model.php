<?php

namespace App\Base\Models;

use App\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends CoreModel
{
    use HasFactory;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    public $timestamps = true;
}
