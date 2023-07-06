<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SettingsAction;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * [this work settings]
     */
    public SettingsAction $works;

    /**
     * [edit account self user]
     */
    public function editAccount(SettingsAction $settingsAction): View
    {
        $works = $settingsAction->editSettings();

        return view('forms.edit.account', compact('works'));
    }

    /**
     * [edit password self user]
     */
    public function editPassword(): View
    {
        return view('forms.edit.password');
    }
}
