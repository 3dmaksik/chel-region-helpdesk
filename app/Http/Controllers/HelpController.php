<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use Illuminate\View\View;

class HelpController extends Controller
{
    public function index(HelpAction $helps): View
    {
        $items = $helps->getAllPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getIndex(HelpAction $helps): View
    {
        $items = $helps->getAllPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function new(HelpAction $helps): View
    {
        $items = $helps->getNewPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getNew(HelpAction $helps): View
    {
        $items = $helps->getNewPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function edit(HelpAction $helps, int $help): View
    {
        $items = $helps->edit($help);

        return view('forms.edit.help', compact('items'));
    }

    public function worker(HelpAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getWorker(HelpAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function completed(HelpAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getCompleted(HelpAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function dismiss(HelpAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('tables.help', compact('items'));
    }

    public function getDismiss(HelpAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('loader.help', compact('items'));
    }

    public function show(HelpAction $helps, int $help): View
    {
        $item = $helps->show($help);

        return view('forms.show.help', compact('item'));
    }

    public function getShow(HelpAction $helps, int $help): View
    {
        $item = $helps->show($help);

        return view('loader.help-view', compact('item'));
    }

    public function create(HelpAction $helps): View
    {
        $items = $helps->create();

        return view('forms.add.help', compact('items'));
    }
}
