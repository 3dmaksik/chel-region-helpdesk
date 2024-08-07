<?php

namespace App\Base\Actions;

use App\Base\DTO\DTO;
use App\Base\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Action
{
    /**
     * [result data]
     *
     * @var response [data => null|Illuminate\Pagination\LengthAwarePaginator,
     *               message => null|string,
     *               route => null|bool,
     *               getload => null|bool,
     *               postLoad => null|bool,
     *               reload => null|bool]
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
