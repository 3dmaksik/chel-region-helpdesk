<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Work extends Model
{
    protected $table = 'work';
    protected $primaryKey = 'id';
    protected $fillable =
    ['firstname',
    'lastname',
    'patronymic',
    'cabinet_id',
    'sound_notify',
    'avatar',];

    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'work',
        ];
    }
}
