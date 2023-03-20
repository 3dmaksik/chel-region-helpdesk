<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CabinetAction;
use Illuminate\View\View;

class CabinetController extends Controller
{
    private CabinetAction $cabinets;
    public function __construct(CabinetAction $cabinets)
    {
        $this->cabinets = $cabinets;
    }

    public function index(): View
    {
        $items = $this->cabinets->getAllPagesPaginate();
        return view('tables.cabinet', compact('items'));
    }

    public function create(): View
    {
        return view('forms.add.cabinet');
    }

    public function edit(int $cabinet): View
    {
        $item = $this->cabinets->show($cabinet);
        return view('forms.edit.cabinet', compact('item'));
    }
}
