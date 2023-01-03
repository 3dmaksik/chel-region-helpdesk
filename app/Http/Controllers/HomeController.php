<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UserAction;
use App\Requests\HelpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    private UserAction $helps;
    public function __construct(UserAction $helps)
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|superAdmin|manager|user']);
        $this->helps = $helps;
    }

    public function worker() : View
    {
        $items = $this->helps->getWorkerPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function completed() : View
    {
        $items = $this->helps->getCompletedPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function dismiss() : View
    {
        $items = $this->helps->getDismissPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function show(int $help): View
    {
        $item = $this->helps->show($help);
        return view('forms.show.help', compact('item'));
    }

    public function create(): View
    {
        $items = $this->helps->create();
        return view('forms.add.user', compact('items'));
    }

    public function store(HelpRequest $request): RedirectResponse
    {
        $this->helps->store($request->validated());
        return redirect()->route(config('constants.user.worker'));
    }
}
