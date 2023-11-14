<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Models\Help;
use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * [all helps]
     */
    public function index(HelpAction $helps): View
    {
        $items = $helps->getAllPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [all helps in api]
     */
    public function loadIndex(HelpAction $helps): View
    {
        $items = $helps->getAllPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [new help]
     */
    public function new(HelpAction $helps): View
    {
        $items = $helps->getNewPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [new help in api]
     */
    public function loadNew(HelpAction $helps): View
    {
        $items = $helps->getNewPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [worker help]
     */
    public function worker(HelpAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [worker help in api]
     */
    public function loadWorker(HelpAction $helps): View
    {
        $items = $helps->getWorkerPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [completed help]
     */
    public function completed(HelpAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [completed help in api]
     */
    public function loadCompleted(HelpAction $helps): View
    {
        $items = $helps->getCompletedPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [dismiss help]
     */
    public function dismiss(HelpAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('tables.help', compact('items'));
    }

    /**
     * [dismiss help in api]
     */
    public function loadDismiss(HelpAction $helps): View
    {
        $items = $helps->getDismissPagesPaginate();

        return view('loader.help', compact('items'));
    }

    /**
     * [create help]
     */
    public function create(HelpAction $helps): View
    {
        $items = $helps->create();

        return view('forms.add.help', compact('items'));
    }

    /**
     * [show one help]
     */
    public function show(HelpAction $helps, int $help): View
    {
        $item = $helps->show($help);

        return view('forms.show.help', compact('item'));
    }

    /**
     * [show one help in api]
     */
    public function loadShow(HelpAction $helps, int $help): View
    {
        $item = $helps->show($help, false);

        return view('loader.help-view-body', compact('item'));
    }
}
