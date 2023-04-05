<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Help extends Model
{
    protected $table = 'help';

    protected $primaryKey = 'id';

    protected $cacheFor = 1;

    protected $fillable =
    ['app_number',
        'category_id',
        'status_id',
        'priority_id',
        'user_id',
        'executor_id',
        'calendar_request',
        'calendar_accept',
        'calendar_warning',
        'calendar_final',
        'calendar_execution',
        'images',
        'description_long',
        'info',
        'info_final',
        'images_final',
        'check_write', ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRoleHelp(Builder $builder): Builder
    {
        if (auth()->user()->roles->pluck('name')[0] === 'superAdmin' || 'admin') {
            return $builder->orderByRaw('CASE WHEN executor_id = '.auth()->user()->id.' THEN executor_id END DESC');
        }
        if (auth()->user()->roles->pluck('name')[0] === 'manager') {
            return $builder->where('executor_id', auth()->user()->id);
        }

        return $builder;
    }

    public function scopeRoleSearch(Builder $builder): Builder
    {
        if (auth()->user()->roles->pluck('name')[0] === 'manager') {
            return $builder->where('executor_id', auth()->user()->id);
        }
        if (auth()->user()->roles->pluck('name')[0] === 'user') {
            return $builder->where('user_id', auth()->user()->id);
        }

        return $builder;
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'help',
        ];
    }
}
