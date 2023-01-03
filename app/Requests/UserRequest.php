<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:256',
                Rule::unique('users')->ignore(empty($this->user) ? 0 : $this->user),
             ],
             'password' => 'required|string|max:256',
             'role' => 'required|string',
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
