<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    protected $table = 'priority';
    protected $primaryKey = 'id';
    protected $fillable = ['description','rang','warning_timer','danger_timer'];
    public function help(): HasMany
    {
        return $this->hasMany(Help::class, 'priority_id');
    }

    protected function setOrder(): Builder
    {
        return $this->orderBy('rang', 'ASC');
    }
}
