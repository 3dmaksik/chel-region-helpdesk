<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Cabinet;
use App\Requests\CabinetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CabinetController extends Controller
{
    const FORMROUTE = 'constants.cabinet';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Cabinet $cabinet): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($cabinet, $this->pages);
        return view('tables.cabinet', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function create(): View
    {
        $generateNames = self::FORMROUTE;
        return view('forms.add.cabinet', compact('generateNames'));
    }

    public function store(CabinetRequest $request, Cabinet $cabinet): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->store($request->validated(), $cabinet);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }

    public function edit(Cabinet $cabinet): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        $item = $this->catalogs->show($cabinet);
        return view('forms.edit.cabinet', compact('item', 'generateNames'));
    }

    public function update(CabinetRequest $request, Cabinet $cabinet): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->update($request->validated(), $cabinet);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $cabinet->id);
    }

    public function destroy(Cabinet $cabinet): RedirectResponse
    {
        // Запуск Action для удаления записи, передача константы для переадресаций
        $item = $this->catalogs->delete($cabinet);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }
}
