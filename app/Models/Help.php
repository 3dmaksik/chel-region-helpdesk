<?php

namespace App\Models;

use App\Base\Models\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Help extends Model
{
    protected $table = 'help';

    protected $primaryKey = 'id';

    protected $cacheFor = 0;

    protected array $lead;

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
        'lead_at',
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

    public function scopeRoleHelpShow(Builder $builder, int $id): Builder
    {
        if (auth()->user()->roles->pluck('name')[0] === 'superAdmin' || 'admin') {
            return $builder->where('id', $id);
        }
        if (auth()->user()->roles->pluck('name')[0] === 'manager' || 'user') {
            return $builder->where('user_id', '5');
        }

        return $builder;
    }

    protected function calendarRequest(): Attribute
    {
        return $this->calendarView();
    }

    protected function calendarAccept(): Attribute
    {
        return $this->calendarView();
    }

    protected function calendarExecution(): Attribute
    {
        return $this->calendarView();
    }

    protected function calendarFinal(): Attribute
    {
        return $this->calendarView();
    }

    protected function calendarWarning(): Attribute
    {
        return $this->calendarView();
    }

    protected function leadAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value != null) {
                    $day = floor($value / 86400);
                    $value = $value % 86400;
                    $hour = floor($value / 3600);
                    $value = $value % 3600;
                    $minute = floor($value / 60);
                    $this->lead =
                    [
                        'day' => (int)$day,
                        'hour' => (int)$hour,
                        'minute' => (int)$minute,
                    ];

                    return $this->lead;
                }
            }
        );
    }

   protected function calendarView(): Attribute
   {
       return Attribute::make(
           get: function ($value) {
               if ($value != null) {
                   return Carbon::parse($value)->format('d.m.Y H:i');
               }
           }
       );
   }

    protected function getCacheBaseTags(): array
    {
        return [
            'help',
        ];
    }
}
