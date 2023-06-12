<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\StatusAction;
use Illuminate\View\View;

class StatusController extends Controller
{
    /**
     * [all status]
     */
    public function index(StatusAction $statusAction): View
    {
        $items = $statusAction->getAllPagesPaginate();

        return view('tables.status', compact('items'));
    }

    /**
     * [edit status]
     */
    public function edit(int $status, StatusAction $statusAction): View
    {
        $item = $statusAction->show($status);

        return view('forms.edit.status', compact('item'));
    }
}
