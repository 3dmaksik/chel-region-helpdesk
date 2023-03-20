<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\NewsAction;
use Illuminate\View\View;

class NewsController extends Controller
{
    private NewsAction $news;
    public function __construct(NewsAction $news)
    {
        $this->news = $news;
    }

    public function index(): View
    {
        $items = $this->news->getAllPagesPaginate();
        return view('pages.news', compact('items'));
    }

    public function show(int $priority): View
    {
        $item = $this->news->show($priority);
        return view('forms.show.news', compact('item'));
    }

    public function create(): View
    {
        return view('forms.add.news');
    }

    public function edit(int $news): View
    {
        $item = $this->news->show($news);
        return view('forms.edit.news', compact('item'));
    }
}
