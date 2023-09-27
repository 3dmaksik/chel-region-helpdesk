<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use App\Models\Category;
use Illuminate\View\View;

final class CategoryController extends Controller
{
    /**
     * [all category]
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
    public function edit(Category $category, CategoryAction $categoryAction): View
    {
        $item = $categoryAction->show($category);

        return view('forms.edit.category', compact('item'));
    }
}
