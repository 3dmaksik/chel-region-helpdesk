<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StatusRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
             'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('status')->ignore(empty($this->status->id) ? 0 : $this->status->id),
                ],
             'color' => 'nullable|string|max:255',
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
