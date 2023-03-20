<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;

class IndexRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:category,id',
            'user_id' => 'required|exists:users,id',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'description_long' => 'required|string',
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return true;
    }
}
