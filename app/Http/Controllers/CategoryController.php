<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryAction $categories;

    public function __construct(CategoryAction $category)
    {
        $this->categories = $category;
    }

    public function index(): View
    {
        $items = $this->categories->getAllPagesPaginate();

        return view('tables.category', compact('items'));
    }

    public function create(): View
    {
        return view('forms.add.category');
    }

    public function edit(int $category): View
    {
        $item = $this->categories->show($category);

        return view('forms.edit.category', compact('item'));
    }
}
