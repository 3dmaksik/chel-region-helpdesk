<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class HelpRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|required|integer|numeric|exists:category,id',
            'status_id' => 'sometimes|required|integer|numeric|exists:status,id',
            'priority_id' => 'sometimes|required|integer|numeric|exists:priority,id',
            'user_id' => 'sometimes|required|integer|numeric|exists:users,id',
            'executor_id' => 'nullable|integer|numeric|exists:users,id',
            'calendar_request' => 'nullable|date',
            'calendar_accept' => 'nullable|date',
            'calendar_final' => 'nullable|date',
            'calendar_execution' => 'nullable|date',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'description_long' => 'sometimes|required|string',
            'info' => 'nullable|string',
            'info_final' => 'sometimes|required|string',
            'images_final.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'check_write' => 'nullable|integer|max:2|numeric',
        ];
    }

    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
