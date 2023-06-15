<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use Illuminate\View\View;

class PriorityController extends Controller
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
    public function show(int $priority, PriorityAction $priorityAction): View
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
    public function edit(int $priority, PriorityAction $priorityAction): View
    {
        $item = $priorityAction->show($priority);

        return view('forms.edit.priority', compact('item'));
    }
}
