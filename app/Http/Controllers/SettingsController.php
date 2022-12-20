<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Base\Helpers\StoreFilesHelper;
use App\Catalogs\Actions\SettingsAction;
use App\Catalogs\Actions\WorkAction;
use App\Requests\PasswordRequest;
use App\Requests\SettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(SettingsAction $settings, WorkAction $work)
    {
        $this->middleware('auth');
        $this->settings = $settings;
        $this->work = $work;
    }

    public function edit(): View
    {
        $works = $this->work->getAllPages();
        return view('forms.edit.settings', compact('works'));
    }

    public function updatePassword(PasswordRequest $request) : RedirectResponse
    {
        $this->settings->updatePassword($request->validated());
        return redirect()->route(config('constants.settings.edit'));
    }

    public function updateSettings(SettingsRequest $request): RedirectResponse
    {
        //DTO добавить и request
        dd(StoreFilesHelper::createNotify($request->sound_notify));
       // $this->settings->updateSettings($request->validated());
        //return redirect()->route(config('constants.settings.edit'));
    }
}
