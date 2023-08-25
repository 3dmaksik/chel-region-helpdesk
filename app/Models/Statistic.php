<?php

namespace App\Models;

use App\Base\Models\Model;

class Statistic extends Model
{
    protected $table = 'statistic';

    protected $primaryKey = 'id';

    protected $fillable = ['description', 'interval', 'total'];
}
