<?php

namespace App\Base\Actions;

use App\Base\Models\Model;
use App\Core\Actions\CoreAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class Action extends CoreAction
{
    public LengthAwarePaginator | Collection $items;
    public Model $item;
    public RedirectResponse $redirect;
    public array $data;
    public int $page = 5;
}
