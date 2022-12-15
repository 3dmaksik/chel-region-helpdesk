<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Priority;
use App\Requests\PriorityRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PriorityController extends Controller
{
    const FORMROUTE = 'constants.priority';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Priority $priority): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($priority, $this->pages);
        return view('tables.priority', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function show(Priority $priority): View
    {
        $generateNames = self::FORMROUTE;
        // Запуск Action c передачей уже проверенного id
        $item = $this->catalogs->show($priority);
        return view('forms.show.priority', compact('item', 'generateNames'));
    }

    public function create(): View
    {
        $generateNames = self::FORMROUTE;
        return view('forms.add.priority', compact('generateNames'));
    }

    public function store(PriorityRequest $request, Priority $priority): RedirectResponse
    {
       // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->store($request->validated(), $priority);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }

    public function edit(Priority $priority): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        $item = $this->catalogs->show($priority);
        return view('forms.edit.priority', compact('item', 'generateNames'));
    }

    public function update(PriorityRequest $request, Priority $priority): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->update($request->validated(), $priority);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $priority->id);
    }

    public function destroy(Priority $priority): RedirectResponse
    {
        // Запуск Action для удаления записи, передача константы для переадресаций
        $item = $this->catalogs->delete($priority);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }
}
