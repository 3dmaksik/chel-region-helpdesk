<?php

namespace App\Models;

use App\Base\Models\Model;

class Priority extends Model
{
    protected $table = 'priority';
    protected $primaryKey = 'id';
    protected $fillable = ['description','rang','warning_timer','danger_timer'];

    protected function getCacheBaseTags(): array
    {
        return [
            'priority',
        ];
    }
}
