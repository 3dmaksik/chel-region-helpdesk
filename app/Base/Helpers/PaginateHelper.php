<?php

declare(strict_types=1);

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

//Base Helper Paginate in Laravel
final class PaginateHelper extends CoreHelper
{
    public static function paginate(Collection $results, int $pageSize): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    protected static function paginator($items, $total, $perPage, $currentPage, $options): LengthAwarePaginator
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items',
            'total',
            'perPage',
            'currentPage',
            'options'
        ));
    }
}
