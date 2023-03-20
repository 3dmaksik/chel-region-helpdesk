<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpController extends Controller
{
    private HelpAction $helps;
    public function __construct(HelpAction $helps)
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|superAdmin|manager'])->only('show', 'update', 'execute');
        $this->middleware(['role:admin|superAdmin'])->only('new', 'workerAdmin', 'dismiss', 'edit', 'accept', 'redefine');
        $this->middleware(['role:manager'])->only('workerManager');
        $this->middleware(['role:superAdmin'])->only('index', 'destroy');
        $this->helps = $helps;
    }

    public function index(): View
    {
        $items = $this->helps->getAllPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function new() : View
    {
        $items = $this->helps->getNewPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function workerAdmin() : View
    {
        $items = $this->helps->getWorkerAdmPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function workerManager() : View
    {
        $items = $this->helps->getWorkerModPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function completedAdmin() : View
    {
        $items = $this->helps->getCompletedAdmPagesPaginate();
        return view('tables.help', compact('items'));
    }

    public function completedManager() : View
    {
        $items = $this->helps->getCompletedModPagesPaginate();
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
        return view('forms.add.help', compact('items'));
    }

    public function store(HelpRequest $request): RedirectResponse
    {
        $this->helps->store($request->validated());
        return redirect()->route(config('constants.help.index'));
    }

    public function edit(int $help): View
    {
        $items = $this->helps->edit($help);
        return view('forms.edit.help', compact('items'));
    }

    public function update(HelpRequest $request, int $help): RedirectResponse
    {
        $item = $this->helps->update($request->validated(), $help);
        return redirect()->route(config('constants.help.index'), $item);
    }

    public function accept(HelpRequest $request, int $help): RedirectResponse
    {
        $item = $this->helps->accept($request->validated(), $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function execute(HelpRequest $request, int $help): RedirectResponse
    {
        $item = $this->helps->execute($request->validated(), $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function redefine(HelpRequest $request, int $help): RedirectResponse
    {
        $item = $this->helps->redefine($request->validated(), $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function reject(HelpRequest $request, int $help): RedirectResponse
    {
        $item = $this->helps->reject($request->validated(), $help);
        return redirect()->route(config('constants.help.show'), $item->id);
    }

    public function destroy(int $help): RedirectResponse
    {
        $this->helps->delete($help);
        return redirect()->route(config('constants.work.index'));
    }
}
