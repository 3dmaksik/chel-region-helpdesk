<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use App\Requests\CabinetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CabinetController extends Controller
{
    public function __construct(CabinetAction $cabinets)
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
        $this->cabinets = $cabinets;
    }

    public function index(): View
    {
        $items = $this->cabinets->getAllPagesPaginate();
        return view('tables.cabinet', compact('items'));
    }

    public function create(): View
    {
        return view('forms.add.cabinet');
    }

    public function store(CabinetRequest $request): RedirectResponse
    {
        $this->cabinets->store($request->validated());
        return redirect()->route(config('constants.cabinet.index'));
    }

    public function edit(int $cabinet): View
    {
        $item = $this->cabinets->show($cabinet);
        return view('forms.edit.cabinet', compact('item'));
    }

    public function update(CabinetRequest $request, int $cabinet): RedirectResponse
    {
        $item = $this->cabinets->update($request->validated(), $cabinet);
        return redirect()->route(config('constants.cabinet.index'), $item);
    }

    public function destroy(int $cabinet): RedirectResponse
    {
        $this->cabinets->delete($cabinet);
        return redirect()->route(config('constants.cabinet.index'));
    }
}
