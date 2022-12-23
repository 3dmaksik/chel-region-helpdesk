<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use App\Requests\StatusRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StatusController extends Controller
{
    const FORMROUTE = 'constants.status';

    public function __construct(StatusAction $statuses)
    {
        $this->middleware('auth');
        $this->statuses = $statuses;
    }

    public function index(): View
    {
        $items = $this->statuses->getAllPagesPaginate();
        return view('tables.status', compact('items'));
    }

    public function edit(int $status): View
    {
        $item = $this->statuses->show($status);
        return view('forms.edit.status', compact('item'));
    }

    public function update(StatusRequest $request, int $status): RedirectResponse
    {
        $item = $this->statuses->update($request->validated(), $status);
        return redirect()->route(config('constants.status.index'), $item);
    }
}
