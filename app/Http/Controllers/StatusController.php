<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Status;
use App\Requests\StatusRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StatusController extends Controller
{
    const FORMROUTE = 'constants.status';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Status $status): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($status, $this->pages);
        return view('tables.status', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function edit(Status $status): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        $item = $this->catalogs->show($status);
        return view('forms.edit.status', compact('item', 'generateNames'));
    }

    public function update(StatusRequest $request, Status $status): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $item = $this->catalogs->update($request->validated(), $status);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $status->id);
    }
}
