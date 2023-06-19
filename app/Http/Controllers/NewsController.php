<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\NewsAction;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * [all news]
     */
    public function index(NewsAction $newsAction): View
    {
        $items = $newsAction->getAllPagesPaginate();

        return view('pages.news', compact('items'));
    }

    /**
     * [show one article]
     */
    public function show(int $priority, NewsAction $newsAction): View
    {
        $item = $newsAction->show($priority);

        return view('forms.show.news', compact('item'));
    }

    /**
     * [new article]
     */
    public function create(): View
    {
        return view('forms.add.news');
    }

    /**
     * [edit article]
     */
    public function edit(int $news, NewsAction $newsAction): View
    {
        $item = $newsAction->show($news);

        return view('forms.edit.news', compact('item'));
    }
}
