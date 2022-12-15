<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\DTO\SearchCatalogsDTO;
use App\Models\Help;
use App\Requests\SearchRequest;
use App\Search\Actions\SearchCatalogAction;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(SearchCatalogAction $catalogs, Help $help)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
        $this->help = $help;
    }

    public function all(SearchRequest $request): View
    {
        $search = $request->validated();
        $generateNames = 'constants.help';
        $items = $this->catalogs->searchHelp($search['search'], $this->pages);
        return view('tables.help', compact('items', 'generateNames'));
    }

    public function work(int $search): View
    {
        $generateNames = 'constants.help';
        $this->data = SearchCatalogsDTO::searchCatalogsObjectRequest($this->help, $this->pages, $search, 'work_id');
        $items = $this->catalogs->searchCatalog($this->data);
        return view('tables.help', compact('items', 'generateNames'));
    }

    public function category(int $search): View
    {
        $generateNames = 'constants.help';
        $this->data = SearchCatalogsDTO::searchCatalogsObjectRequest($this->help, $this->pages, $search, 'category_id');
        $items = $this->catalogs->searchCatalog($this->data);
        return view('tables.help', compact('items', 'generateNames'));
    }

    public function cabinet(int $search): View
    {
        $generateNames = 'constants.help';
        $this->data = SearchCatalogsDTO::searchCatalogsObjectRequest($this->help, $this->pages, $search, 'cabinet_id');
        $items = $this->catalogs->searchCatalog($this->data);
        return view('tables.help', compact('items', 'generateNames'));
    }
}
