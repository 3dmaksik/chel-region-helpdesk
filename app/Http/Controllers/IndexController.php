<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\IndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndexController extends Controller
{
    private HelpAction $helps;

    public function __construct(HelpAction $helps)
    {
        $this->helps = $helps;
    }

    public function index(): View
    {
        $items = $this->helps->create();

        return view('pages.index', compact('items'));
    }

    public function store(IndexRequest $request): RedirectResponse
    {
        $this->helps->store($request->validated());

        return redirect()->route('/');
    }
}
