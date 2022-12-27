<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SearchCatalogAction;
use App\Catalogs\DTO\SearchCatalogsDTO;
use App\Requests\SearchRequest;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(SearchCatalogAction $catalogs)
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|superAdmin']);
        $this->catalogs = $catalogs;
    }

    public function all(SearchRequest $request): View
    {
        $search = $request->validated();
        $items = $this->catalogs->searchHelp($search['search'], $this->pages);
        return view('tables.help', compact('items'));
    }

    public function work(int $search): View
    {
        $this->data = SearchCatalogsDTO::searchWorkObjectRequest($search);
        $items = $this->catalogs->searchHelpWith($this->data);
        return view('tables.help', compact('items'));
    }

    public function category(int $search): View
    {
        $this->data = SearchCatalogsDTO::searchCategoryObjectRequest($search);
        $items = $this->catalogs->searchHelpWith($this->data);
        return view('tables.help', compact('items'));
    }

    public function cabinet(int $search): View
    {
        $this->data = SearchCatalogsDTO::searchCabinetObjectRequest($search);
        $items = $this->catalogs->searchHelpWith($this->data);
        return view('tables.help', compact('items'));
    }
}
