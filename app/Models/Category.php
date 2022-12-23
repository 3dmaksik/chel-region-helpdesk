<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = ['description'];
    public function help(): HasMany
    {
        return $this->hasMany(Help::class, 'category_id');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'category',
        ];
    }
}
