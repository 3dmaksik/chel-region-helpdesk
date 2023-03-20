<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\PriorityAction;
use Illuminate\View\View;

class PriorityController extends Controller
{
    private PriorityAction $priorities;
    public function __construct(PriorityAction $priorities)
    {
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

    public function edit(int $priority): View
    {
        $item = $this->priorities->show($priority);
        return view('forms.edit.priority', compact('item'));
    }
}
