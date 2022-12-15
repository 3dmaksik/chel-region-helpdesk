<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Help\DTO\HelpDTO;
use App\Help\Helpers\CheckHelpHelper;
use App\Models\Help;
use App\Requests\HelpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpController extends Controller
{
    const FORMROUTE = 'constants.help';

    public function __construct(CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->catalogs = $catalogs;
    }

    public function index(Help $help): View
    {
       // Запуск Action для получения всех записей
        $generateNames = self::FORMROUTE;
        $items = $this->catalogs->getAllCatalogs($help, $this->pages);
        return view('tables.help', compact('items', 'generateNames'));
       // return app(TestTransformer::class)->transform($test);
    }

    public function show(Help $help): View
    {
        $generateNames = self::FORMROUTE;
        //Обновление просмотра заявки
        CheckHelpHelper::checkUpdate($help->id);
        // Запуск Action c передачей уже проверенного id
        $item = $this->catalogs->show($help);
        return view('forms.show.help', compact('item', 'generateNames'));
    }

    public function create(AllCatalogsDTO $all): View
    {
        $generateNames = self::FORMROUTE;
        $data = $all->getAllCatalogsCollection();
        return view('forms.add.help', compact('generateNames', 'data'));
    }

    public function store(HelpRequest $request, Help $help): RedirectResponse
    {
       // Запуск Action для сохранение записи, передача константы для переадресаций
        $data = HelpDTO::storeObjectRequest($request->validated());
        $item = $this->catalogs->store((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }

    public function edit(AllCatalogsDTO $all, Help $help): View
    {
        // Запуск Action c передачей уже проверенной модели
        $generateNames = self::FORMROUTE;
        //Все каталоги
        $data = $all->getAllCatalogsCollection();
        //Обновление просмотра заявки
        CheckHelpHelper::checkUpdate($help->id);
        $item = $this->catalogs->show($help);
        return view('forms.edit.help', compact('item', 'generateNames', 'data'));
    }

    public function update(HelpRequest $request, Help $help): RedirectResponse
    {
        // Запуск Action для сохранение записи, передача константы для переадресаций
        $data = HelpDTO::storeObjectRequest($request->validated());
        $item = $this->catalogs->update((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'), $help->id);
    }

    public function accept(HelpRequest $request, Help $help): RedirectResponse
    {
        $data = HelpDTO::acceptObjectRequest($request->validated(), $help);
        $item = $this->catalogs->update((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.show'), $help->id);
    }

    public function execute(HelpRequest $request, Help $help): RedirectResponse
    {
        $data = HelpDTO::executeObjectRequest($request->validated(), $help);
        $item = $this->catalogs->update((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.show'), $help->id);
    }

    public function redefine(HelpRequest $request, Help $help): RedirectResponse
    {
        $data = HelpDTO::redefineObjectRequest($request->validated());
        $item = $this->catalogs->update((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.show'), $help->id);
    }

    public function reject(HelpRequest $request, Help $help): RedirectResponse
    {
        $data = HelpDTO::rejectObjectRequest($request->validated(), $help);
        $item = $this->catalogs->update((array) $data, $help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.show'), $help->id);
    }

    public function destroy(Help $help): RedirectResponse
    {
        // Запуск Action для удаления записи, передача константы для переадресаций
        $item = $this->catalogs->delete($help);
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.index'));
    }
}
