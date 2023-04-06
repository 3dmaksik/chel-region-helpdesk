<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use Illuminate\View\View;

class HelpController extends Controller
{
    private HelpAction $helps;

    public function __construct(HelpAction $helps)
    {
        $this->helps = $helps;
    }

    public function index(): View
    {
        $items = $this->helps->getAllPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getIndex(): View
    {
        $items = $this->helps->getAllPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function new(): View
    {
        $items = $this->helps->getNewPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getNew(): View
    {
        $items = $this->helps->getNewPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function edit(int $help): View
    {
        $items = $this->helps->edit($help);

        return view('forms.edit.help', compact('items'));
    }

    public function worker(): View
    {
        $items = $this->helps->getWorkerPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getWorker(): View
    {
        $items = $this->helps->getWorkerPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function completed(): View
    {
        $items = $this->helps->getCompletedPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getCompleted(): View
    {
        $items = $this->helps->getCompletedPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function dismiss(): View
    {
        $items = $this->helps->getDismissPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getDismiss(): View
    {
        $items = $this->helps->getDismissPagesPaginate();

        return view('loader.help', compact('items'));
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
}
