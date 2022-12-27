<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UserAction;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Requests\HelpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{

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
        $data = AllCatalogsDTO::getAllCatalogsCollection();
        return view('forms.add.user', compact('data'));
    }

    public function store(HelpRequest $request): RedirectResponse
    {
        $data = HelpDTO::storeObjectRequest($request->validated());
        $this->helps->store((array) $data);
        return redirect()->route(config('constants.user.worker'));
    }
}
