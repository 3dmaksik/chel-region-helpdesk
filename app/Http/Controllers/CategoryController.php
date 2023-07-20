<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * [all category]
     *
     * @param type [$categorytAction] categoryAction
     */
    public function index(CategoryAction $categoryAction): View
    {
        $items = $categoryAction->getAllPagesPaginate();

        return view('tables.category', compact('items'));
    }

    /**
     * [new category]
     */
    public function create(): View
    {
        return view('forms.add.category');
    }

    /**
     * [edit category]
     */
    public function edit(int $category, CategoryAction $categoryAction): View
    {
        $item = $categoryAction->show($category);

        return view('forms.edit.category', compact('item'));
    }
}
