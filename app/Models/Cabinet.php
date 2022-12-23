<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabinet extends Model
{
    protected $table = 'cabinet';
    protected $primaryKey = 'id';
    protected $fillable = ['description'];
    public function help(): HasMany
    {
        return $this->hasMany(Help::class, 'cabinet_id');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'cabinet',
        ];
    }
}
