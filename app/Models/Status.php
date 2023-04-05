<?php

namespace App\Models;

use App\Base\Models\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $primaryKey = 'id';

    protected $fillable = ['description', 'color'];

    protected function getCacheBaseTags(): array
    {
        return [
            'status',
        ];
    }
}
