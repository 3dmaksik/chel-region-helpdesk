<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SettingsAction;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private SettingsAction $settings;

    public function __construct(SettingsAction $settings)
    {
        $this->settings = $settings;
    }

    public function editAccount(): View
    {
        $works = $this->settings->editSettings();

        return view('forms.edit.account', compact('works'));
    }

    public function editPassword(): View
    {
        return view('forms.edit.password');
    }
}
