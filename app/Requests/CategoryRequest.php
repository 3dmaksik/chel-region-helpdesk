<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
             'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category')->ignore(empty($this->caregory->id) ? 0 : $this->category->id),
             ],
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
