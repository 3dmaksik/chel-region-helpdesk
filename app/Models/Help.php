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

    protected array $lead;

    protected $fillable = [
        'app_number',
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
        'images_final',
        'files',
        'files_final',
        'description_long',
        'info',
        'info_final',
        'images_final',
        'files_remove',
        'files_final_remove',
        'check_write',
    ];

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
        if (auth()->user()->roles->pluck('name')[0] === 'manager') {
            return $builder->where('executor_id', auth()->user()->id);
        }
        if (auth()->user()->roles->pluck('name')[0] === 'superAdmin' || 'admin') {
            return $builder->orderByRaw('CASE WHEN executor_id = '.auth()->user()->id.' THEN executor_id END DESC');
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

    protected function calendarView(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return Carbon::parse($value)->format('d.m.Y H:i');
                }
            }
        );
    }

    protected function leadAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    $day = floor($value / 86400);
                    $value %= 86400;
                    $hour = floor($value / 3600);
                    $value %= 3600;
                    $minute = floor($value / 60);
                    $value < 60 ? $second = $value : $second = 0;
                    $this->lead =
                    [
                        'day' => (int) $day,
                        'hour' => (int) $hour,
                        'minute' => (int) $minute,
                        'second' => (int) $second,
                    ];

                    return $this->lead;
                }
            }
        );
    }

    protected function images(): Attribute
    {
        return $this->filesJson();
    }

    protected function imagesFinal(): Attribute
    {
        return $this->filesJson();
    }

    protected function files(): Attribute
    {
        return $this->filesJson();
    }

    protected function filesFinal(): Attribute
    {
        return $this->filesJson();
    }

    protected function filesJson(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return json_decode((string) $value, true, JSON_THROW_ON_ERROR);
                }
            }
        );
    }
}
