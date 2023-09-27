<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;

class IndexUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:category,id',
            'user_id' => 'required|exists:users,id',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'description_long' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
