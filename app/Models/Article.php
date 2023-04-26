<?php

namespace App\Models;

use App\Base\Models\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function createdAt(): Attribute
    {
    return Attribute::make(
        get: function ($value) {
            if ($value != null) {
                return Carbon::parse($value)->format('d.m.Y H:i');
            }
        }
    );
   }
}
