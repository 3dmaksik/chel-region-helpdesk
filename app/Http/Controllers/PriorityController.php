<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use App\Requests\PriorityRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PriorityController extends Controller
{
    public function __construct(PriorityAction $priorities)
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
        $this->priorities = $priorities;
    }

    public function index(): View
    {
        $items = $this->priorities->getAllPagesPaginate();
        return view('tables.priority', compact('items'));
    }

    public function show(int $priority): View
    {
        $item = $this->priorities->show($priority);
        return view('forms.show.priority', compact('item'));
    }

    public function create(): View
    {
        return view('forms.add.priority');
    }

    public function store(PriorityRequest $request): RedirectResponse
    {
        $this->priorities->store($request->validated());
        return redirect()->route(config('constants.priority.index'));
    }

    public function edit(int $priority): View
    {
        $item = $this->priorities->show($priority);
        return view('forms.edit.priority', compact('item'));
    }

    public function update(PriorityRequest $request, int $priority): RedirectResponse
    {
        $item = $this->priorities->update($request->validated(), $priority);
        return redirect()->route(config('constants.priority.index'), $item);
    }

    public function destroy(int $priority): RedirectResponse
    {
        $this->priorities->delete($priority);
        return redirect()->route(config('constants.priority.index'));
    }
}
