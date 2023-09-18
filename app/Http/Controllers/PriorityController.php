<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use App\Models\Priority;
use Illuminate\View\View;

final class PriorityController extends Controller
{
    /**
     * [all priority]
     */
    public function index(PriorityAction $priorityAction): View
    {
        $items = $priorityAction->getAllPagesPaginate();

        return view('tables.priority', compact('items'));
    }

    /**
     * [show one priority]
     */
    public function show(Priority $priority, PriorityAction $priorityAction): View
    {
        $item = $priorityAction->show($priority);

        return view('forms.show.priority', compact('item'));
    }

    /**
     * [new priority]
     */
    public function create(): View
    {
        return view('forms.add.priority');
    }

    /**
     * [edit priority]
     */
    public function edit(Priority $priority, PriorityAction $priorityAction): View
    {
        $item = $priorityAction->show($priority);

        return view('forms.edit.priority', compact('item'));
    }
}
