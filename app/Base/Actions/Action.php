<?php

namespace App\Base\Actions;

use App\Base\DTO\DTO;
use App\Base\Models\Model;
use App\Core\Actions\CoreAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class Action extends CoreAction
{
    public LengthAwarePaginator|Collection|SimpleCollection $items;

    public Model $item;

    public RedirectResponse $redirect;

    public array|DTO $data;

    public int $page;

    public function __construct()
    {
        $this->page = config('settings.pages');
    }
}
