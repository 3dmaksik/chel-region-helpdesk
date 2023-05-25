<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class UserPasswordRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'password' => 'required|string|max:255',
        ];
    }

    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
