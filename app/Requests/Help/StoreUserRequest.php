<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|numeric|exists:category,id',
            'description_long' => 'required|string',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
