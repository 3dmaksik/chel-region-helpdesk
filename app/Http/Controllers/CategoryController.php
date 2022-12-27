<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\CategoryAction;
use App\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(CategoryAction $category)
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
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

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categories->store($request->validated());
        return redirect()->route(config('constants.category.index'));
    }

    public function edit(int $category): View
    {
        $item = $this->categories->show($category);
        return view('forms.edit.category', compact('item'));
    }

    public function update(CategoryRequest $request, int $category): RedirectResponse
    {
        $item = $this->categories->update($request->validated(), $category);
        return redirect()->route(config('constants.category.index'), $item);
    }

    public function destroy(int $category): RedirectResponse
    {
        $this->categories->delete($category);
        return redirect()->route(config('constants.category.index'));
    }
}
