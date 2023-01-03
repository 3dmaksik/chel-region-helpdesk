<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\WorkAction;
use App\Requests\WorkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkController extends Controller
{
    private WorkAction $works;
    public function __construct(WorkAction $works)
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
        $this->works = $works;
    }

    public function index(): View
    {
        $items = $this->works->getAllPagesPaginate();
        return view('tables.work', compact('items'));
    }

    public function show(int $work): View
    {
        $item = $this->works->show($work);
        return view('forms.show.work', compact('item'));
    }

    public function create(): View
    {
        $items = $this->works->create();
        return view('forms.add.work', compact('items'));
    }

    public function store(WorkRequest $request): RedirectResponse
    {
        $this->works->store($request->validated());
        return redirect()->route(config('constants.work.index'));
    }

    public function edit(int $work): View
    {
        $items = $this->works->edit($work);
        return view('forms.edit.work', compact('items'));
    }

    public function update(WorkRequest $request, int $work): RedirectResponse
    {
        $item = $this->works->update($request->validated(), $work);
        return redirect()->route(config('constants.work.index'), $item);
    }

    public function destroy(int $work): RedirectResponse
    {
        $this->works->delete($work);
        return redirect()->route(config('constants.work.index'));
    }
}
