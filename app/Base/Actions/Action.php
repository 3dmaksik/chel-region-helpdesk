<?php

namespace App\Base\Actions;

use App\Base\Models\Model;
use App\Core\Actions\CoreAction;
use App\Core\Resources\CoreResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Action extends CoreAction
{
    /**
     * [many items]
     */
    public Collection|LengthAwarePaginator $items;

    /**
     * [base model or null]
     */
    public ?Model $item = null;

    /**
     * [resource for database or result data]
     */
    public CoreResource $resource;

    /**
     * [data for database or result data]
     */
    public array $data;

    /**
     * [page in config paginate]
     */
    public int $page;

    /**
     * [Current page for cache]
     */
    public int|string $currentPage;

    /**
     * [setup for all pages]
     *
     * @return void
     */
    public function __construct()
    {
        $this->page = config('settings.pages');
    }
}
