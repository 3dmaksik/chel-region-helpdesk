<?php

namespace App\Models;

use App\Base\Models\Model;

class Cabinet extends Model
{
    protected $table = 'cabinet';

    protected $primaryKey = 'id';

    protected $fillable = ['description'];
}
