<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use Illuminate\View\View;

class CabinetController extends Controller
{
    /**
     * [all cabinet]
     *
     * @param type [$cabinetAction] cabinetAction
     */
    public function index(CabinetAction $cabinetAction): View
    {
        $items = $cabinetAction->getAllPagesPaginate();

        return view('tables.cabinet', compact('items'));
    }

    /**
     * [all cabinet for loader]
     *
     * @param type [$cabinetAction] cabinetAction
     */
    public function getIndex(CabinetAction $cabinetAction): View
    {
        $items = $cabinetAction->getAllPagesPaginate();

        return view('loader.cabinet', compact('items'));
    }

    /**
     * [new cabinet]
     */
    public function create(): View
    {
        return view('forms.add.cabinet');
    }

    /**
     * [edit cabinet]
     *
     * @param type [$cabinetAction] cabinetAction
     */
    public function edit(int $cabinet, CabinetAction $cabinetAction): View
    {
        $item = $cabinetAction->show($cabinet);

        return view('forms.edit.cabinet', compact('item'));
    }
}
