<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\IndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * [index page helpdesk]
     */
    public function index(HelpAction $helps): View
    {
        $items = $helps->create();

        return view('pages.index', compact('items'));
    }
}
