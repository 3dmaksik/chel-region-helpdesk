<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class Priority extends Model
{
    protected $table = 'priority';
    protected $primaryKey = 'id';
    protected $fillable = ['description','rang','warning_timer','danger_timer'];

    protected function setOrder(): Builder
    {
        return $this->orderBy('rang', 'ASC');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'priority',
        ];
    }
}
