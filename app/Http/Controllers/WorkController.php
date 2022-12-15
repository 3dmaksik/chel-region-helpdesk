<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Work;
use App\Requests\WorkRequest;
use App\Work\DTO\WorkDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkController extends Controller
{
    const FORMROUTE = 'constants.work';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Work $work): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($work, $this->pages);
        return view('tables.work', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function show(Work $work): View
    {
        $generateNames = self::FORMROUTE;
        // Запуск Action c передачей уже проверенного id
        $item = $this->catalogs->show($work);
        return view('forms.show.work', compact('item', 'generateNames'));
    }

    public function create(): View
    {
        $generateNames = self::FORMROUTE;
        return view('forms.add.work', compact('generateNames'));
    }

    public function store(WorkRequest $request, Work $work): RedirectResponse
    {
        $data = WorkDTO::storeObjectRequest($request->validated());
        $item = $this->catalogs->store((array) $data, $work);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }

    public function edit(Work $work): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        $item = $this->catalogs->show($work);
        return view('forms.edit.work', compact('item', 'generateNames'));
    }

    public function update(WorkRequest $request, Work $work): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $data = WorkDTO::storeObjectRequest($request->validated());
        $item = $this->catalogs->update((array) $data, $work);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $work->id);
    }

    public function destroy(Work $work): RedirectResponse
    {
        // Запуск Action для удаления записи, передача константы для переадресаций
        $item = $this->catalogs->delete($work);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }
}
