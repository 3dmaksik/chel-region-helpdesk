<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class SettingsRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [];
    }

    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
