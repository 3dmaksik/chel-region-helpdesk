<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SearchCatalogAction;
use App\Requests\Search\SearchRequest;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(private readonly SearchCatalogAction $catalogs) {}

    public function all(SearchRequest $request): View
    {
        $items = $this->catalogs->searchHelp($request->validated(null, null));

        return view('tables.help', compact('items'));
    }

    public function work(int $search): View
    {
        $items = $this->catalogs->searchHelpWork($search);

        return view('tables.help', compact('items'));
    }

    public function category(int $search): View
    {
        $items = $this->catalogs->searchHelpCategory($search);

        return view('tables.help', compact('items'));
    }

    public function cabinet(int $search): View
    {
        $items = $this->catalogs->searchHelpCabinet($search);

        return view('tables.help', compact('items'));
    }
}
