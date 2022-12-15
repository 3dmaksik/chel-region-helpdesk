<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Category;
use App\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    const FORMROUTE = 'constants.category';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Category $category): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($category, $this->pages);
        return view('tables.category', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function show(Category $category): View
    {
        $generateNames = self::FORMROUTE;
        // Запуск Action c передачей уже проверенного id
        $item = $this->catalogs->show($category);
        return view('forms.show.category', compact('item', 'generateNames'));
    }

    public function create(): View
    {
        $generateNames = self::FORMROUTE;
        return view('forms.add.category', compact('generateNames'));
    }

    public function store(CategoryRequest $request, Category $category): RedirectResponse
    {
       // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->store($request->validated(), $category);

        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }

    public function edit(Category $category): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        $item = $this->catalogs->show($category);
        return view('forms.edit.category', compact('item', 'generateNames'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->update($request->validated(), $category);

        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $category->id);
    }

    public function destroy(Category $category): RedirectResponse
    {
        // Запуск Action для удаления записи, передача константы для переадресаций
        $item = $this->catalogs->delete($category);

        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }
}
