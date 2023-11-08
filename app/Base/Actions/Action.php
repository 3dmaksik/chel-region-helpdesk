<?php

namespace App\Base\Actions;

use App\Base\DTO\DTO;
use App\Base\Models\Model;
use App\Core\Actions\CoreAction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Action extends CoreAction
{
    /**
     * [result data]
     *
     * @var response [data => null|Illuminate\Pagination\LengthAwarePaginator,
     *                message => null|string,
     *                route => null|bool,
     *                loading => null|bool,
     *                load => null|bool,
     *                reload => null|bool]
     */
    public array $response;

    /**
     * [many items]
     */
    public Collection|LengthAwarePaginator $items;

    /**
     * [base model or null]
     */
    public ?Model $item;

    /**
     * [data for database or result data]
     */
    public array $data;

    /**
     * [data object for database]
     */
    public DTO $dataObject;

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
