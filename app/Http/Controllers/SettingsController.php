<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\RedirectHelper;
use App\Catalogs\Actions\CatalogsAction;
use App\Models\Work;
use App\Requests\PasswordRequest;
use App\Settings\Actions\SettingsAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    const FORMROUTE = 'constants.settings';

    public function __construct(SettingsAction $settings, CatalogsAction $catalogs)
    {
        $this->middleware('auth');
        $this->settings = $settings;
        $this->catalogs = $catalogs;
    }

    public function edit(Work $work): View
    {
        $generateNames = self::FORMROUTE;
        $item = $this->settings->show();
        $works = $this->catalogs->getAllCatalogs($work);
        return view('forms.edit.settings', compact('generateNames', 'item', 'works'));
    }

    public function updatePassword(PasswordRequest $request) : RedirectResponse
    {
        $item = $this->settings->updatePassword($request->validated());
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.edit'));
    }

    public function updateSettings(PasswordRequest $request): RedirectResponse
    {
        //DTO добавить
        $item = $this->settings->updateSettings($request->validated());
        return RedirectHelper::redirect($item, config(self::FORMROUTE . '.edit'));
    }
}
