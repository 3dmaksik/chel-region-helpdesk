<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\WorkAction;
use App\Catalogs\DTO\WorkDTO;
use App\Requests\WorkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function __construct(WorkAction $works)
    {
        $this->middleware('auth');
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
        return view('forms.add.work');
    }

    public function store(WorkRequest $request): RedirectResponse
    {
        $data = WorkDTO::storeObjectRequest($request->validated());
        $this->works->store((array) $data);
        return redirect()->route(config('constants.work.index'));
    }

    public function edit(int $work): View
    {
        $item = $this->works->show($work);
        return view('forms.edit.work', compact('item'));
    }

    public function update(WorkRequest $request, int $work): RedirectResponse
    {
        $data = WorkDTO::storeObjectRequest($request->validated());
        $item = $this->works->update((array) $data, $work);
        return redirect()->route(config('constants.work.index'), $item);
    }

    public function destroy(int $work): RedirectResponse
    {
        $this->works->delete($work);
        return redirect()->route(config('constants.work.index'));
    }
}
