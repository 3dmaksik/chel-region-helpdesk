<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class WorkRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
             'firstname' => 'required|string|max:256',
             'lastname' => 'required|string|max:256',
             'patronymic' => 'nullable|string|max:256',
             'encrypt_description' => 'nullable',
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
