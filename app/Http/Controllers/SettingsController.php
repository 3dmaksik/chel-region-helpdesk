<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * [edit account self user]
     */
    public function editAccount(): View
    {
        return view('forms.edit.account');
    }

    /**
     * [edit password self user]
     */
    public function editPassword(): View
    {
        return view('forms.edit.password');
    }
}
