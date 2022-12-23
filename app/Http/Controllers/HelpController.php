<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Requests\HelpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpController extends Controller
{

    public function __construct(HelpAction $helps)
    {
        $this->middleware('auth');
        $this->helps = $helps;
    }

    public function index(): View
    {
        $items = $this->helps->getAllPagesPaginate();
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
        return view('forms.add.help', compact('data'));
    }

    public function store(HelpRequest $request): RedirectResponse
    {
        $data = HelpDTO::storeObjectRequest($request->validated());
        $this->helps->store((array) $data);
        return redirect()->route(config('constants.help.index'));
    }

    public function edit(int $help): View
    {
        $data = AllCatalogsDTO::getAllCatalogsCollection();
        $item = $this->helps->show($help);
        return view('forms.edit.help', compact('item', 'data'));
    }

    public function update(HelpRequest $request, int $help): RedirectResponse
    {
        $data = HelpDTO::storeObjectRequest($request->validated());
        $item = $this->helps->update((array) $data, $help);
        return redirect()->route(config('constants.help.index'), $item);
    }

    public function accept(HelpRequest $request, int $help): RedirectResponse
    {
        $data = HelpDTO::acceptObjectRequest($request->validated(), $help);
        $item = $this->helps->update((array) $data, $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function execute(HelpRequest $request, int $help): RedirectResponse
    {
        $data = HelpDTO::executeObjectRequest($request->validated());
        $item = $this->helps->update((array) $data, $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function redefine(HelpRequest $request, int $help): RedirectResponse
    {
        $data = HelpDTO::redefineObjectRequest($request->validated());
        $item = $this->helps->update((array) $data, $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function reject(HelpRequest $request, int $help): RedirectResponse
    {
        $data = HelpDTO::rejectObjectRequest($request->validated());
        $item = $this->helps->update((array) $data, $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function destroy(int $help): RedirectResponse
    {
        $this->helps->delete($help);
        return redirect()->route(config('constants.work.index'));
    }
}
