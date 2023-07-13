<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\IndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __construct(private readonly HelpAction $helps)
    {
    }

    public function index(): View
    {
        $items = $this->helps->create();

        return view('pages.index', compact('items'));
    }

    public function store(IndexRequest $request): RedirectResponse
    {
        $this->helps->store($request->validated(null, null));

        return redirect()->route('/');
    }
}
