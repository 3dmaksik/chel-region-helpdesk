<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Help extends Model
{
    protected $table = 'help';
    protected $primaryKey = 'id';
    protected $fillable =
    ['category_id',
    'status_id',
    'cabinet_id',
    'priority_id',
    'work_id',
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
    'check_write',];
    protected $cacheFor = 1;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    protected function setOrder(): Builder
    {
        return $this->orderBy('status_id', 'ASC')
        ->orderBy('calendar_execution', 'ASC')
        ->orderBy('calendar_warning', 'ASC')
        ->orderBy('calendar_final', 'DESC');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'help',
        ];
    }
}
