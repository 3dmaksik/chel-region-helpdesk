<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class HelpRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|required|integer|numeric|exists:category,id',
            'priority_id' => 'sometimes|required|integer|numeric|exists:priority,id',
            'user_id' => 'sometimes|required|integer|numeric|exists:users,id',
            'executor_id' => 'sometimes|required|integer|numeric|exists:users,id',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'images_final.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'description_long' => 'sometimes|required|string',
            'info' => 'nullable|string',
            'info_final' => 'sometimes|required|string',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
