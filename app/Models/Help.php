<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getNewPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 2)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($pages);
    }

    public function getModWorkerPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 1)
        ->where('executor_id', auth()->user()->id)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($pages);
    }

    public function getAdmWorkerPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 1)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($pages);
    }

    public function getUserWorkerPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('work_id', auth()->user()->id)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($pages);
    }

    public function getModCompletedPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 3)
        ->where('executor_id', auth()->user()->id)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($pages);
    }

    public function getUserCompletedPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 3)
        ->where('work_id', auth()->user()->id)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($pages);
    }

    public function getAdmDismissPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 4)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($pages);
    }

    public function getUserDismissPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 4)
        ->where('work_id', auth()->user()->id)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($pages);
    }

    public function getAdmCompletedPaginateItems(int $pages): LengthAwarePaginator
    {
        return $this->where('status_id', 3)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($pages);
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'help',
        ];
    }
}
