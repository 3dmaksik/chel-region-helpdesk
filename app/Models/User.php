<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rennokki\QueryCache\Traits\QueryCacheable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //use HasApiTokens;
    use QueryCacheable;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $cacheFor = 10080;

    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'patronymic',
        'cabinet_id',
        'sound_notify',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class);
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'users',
        ];
    }
}
