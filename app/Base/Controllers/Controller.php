<?php

namespace App\Base\Controllers;

use App\Core\Controllers\CoreController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class Controller extends CoreController
{
    public LengthAwarePaginator $items;
    public RedirectResponse $redirect;
    public string $generateNames;
    public int $pages = 5;
}
