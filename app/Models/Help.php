<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Help extends Model
{
    protected $table = 'help';
    protected $primaryKey = 'id';
    protected $cacheFor = 1;
    protected $fillable =
    ['category_id',
    'status_id',
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

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'help',
        ];
    }
}
