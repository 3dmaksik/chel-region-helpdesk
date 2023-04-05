<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HomeAction;
use Illuminate\View\View;

class HomeController extends Controller
{
    private HomeAction $helps;

    public function __construct(HomeAction $helps)
    {
        $this->helps = $helps;
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

        return view('forms.add.home', compact('items'));
    }
}
