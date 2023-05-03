<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccountRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'avatar' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'sound_notify' => 'nullable|mimes:opus,oga,ogg|max:20480',
        ];
    }

    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
