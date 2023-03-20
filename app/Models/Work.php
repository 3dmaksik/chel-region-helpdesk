<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Work extends Model
{
    protected $table = 'work';
    protected $primaryKey = 'id';
    protected $fillable =
    ['firstname',
    'lastname',
    'patronymic',
    'cabinet_id',
    'user_id',
    'sound_notify',
    'avatar',];

    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'work',
        ];
    }
}
