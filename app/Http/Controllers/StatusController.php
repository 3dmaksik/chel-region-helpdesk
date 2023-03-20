<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use Illuminate\View\View;

class StatusController extends Controller
{
    private StatusAction $statuses;

    public function __construct(StatusAction $statuses)
    {
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
}
