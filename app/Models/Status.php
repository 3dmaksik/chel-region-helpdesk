<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $fillable = ['description','color'];
    public function help(): HasMany
    {
        return $this->hasMany(Help::class, 'status_id');
    }
}
