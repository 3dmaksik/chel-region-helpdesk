<?php

namespace App\Models;

use App\Base\Models\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = ['description'];

    protected function getCacheBaseTags(): array
    {
        return [
            'category',
        ];
    }
}
