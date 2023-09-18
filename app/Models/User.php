<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use HasRoles;
    use Notifiable;

    final public const CREATED_AT = 'created_at';

    final public const UPDATED_AT = 'updated_at';

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'patronymic',
        'cabinet_id',
        'avatar',
        'sound_notify',
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
}
