<?php

namespace App\Base\Actions;

use App\Base\DTO\DTO;
use App\Base\Models\Model;
use App\Core\Actions\CoreAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class Action extends CoreAction
{
    /**
     * [many items]
     */
    public LengthAwarePaginator|Collection|SimpleCollection $items;

    /**
     * [base model or null]
     */
    public ?Model $item;

    /**
     * [data for database or result data]
     */
    public array|DTO $data;

    /**
     * [Description for $page]
     */
    public int $page;

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
