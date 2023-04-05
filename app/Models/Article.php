<?php

namespace App\Models;

use App\Base\Models\Model;

class Article extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'news_text', 'created_at'];

    protected function getCacheBaseTags(): array
    {
        return [
            'news',
        ];
    }
}
