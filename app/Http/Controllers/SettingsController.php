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

    public function edit(): View
    {
        $works = $this->settings->editSettings();

        return view('forms.edit.settings', compact('works'));
    }
}
