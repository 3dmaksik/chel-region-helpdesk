<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Catalogs\Actions\HomeAction;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * [worker help]
     */
    public function worker(HomeAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [worker help in api]
     */
    public function getWorker(HomeAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [completed help]
     */
    public function completed(HomeAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [completed help in api]
     */
    public function getCompleted(HomeAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [dismiss]
     */
    public function dismiss(HomeAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [dismiss help in api]
     */
    public function getDismiss(HomeAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [show one help]
     */
    public function show(int $help, HelpAction $helps): View
    {
        $item = $helps->show($help);

        return view('forms.show.help', compact('item'));
    }

    /**
     * [create help]
     */
    public function create(HelpAction $helps): View
    {
        $items = $helps->create();

        return view('forms.add.home', compact('items'));
    }
}
