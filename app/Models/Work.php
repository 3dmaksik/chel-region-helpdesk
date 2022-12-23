<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    protected $table = 'work';
    protected $primaryKey = 'id';
    protected $fillable = ['firstname','lastname','patronymic','encrypt_description'];
    public function help(): HasMany
    {
        return $this->hasMany(Help::class, 'work_id');
    }

    protected function setOrder(): Builder
    {
        return $this->orderBy('id', 'DESC');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'work',
        ];
    }
}
