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
            'category_id' => 'sometimes|required|exists:category,id',
            'status_id' => 'nullable|exists:status,id',
            'cabinet_id' => 'sometimes|required|exists:cabinet,id',
            'priority_id' => 'sometimes|required|exists:priority,id',
            'work_id' => 'sometimes|required|exists:work,id',
            'executor_id' => 'nullable|exists:work,id',
            'calendar_request' => 'nullable|date',
            'calendar_accept' => 'nullable|date',
            'calendar_final' => 'nullable|date',
            'calendar_execution' => 'nullable|date',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'description_long' => 'sometimes|required|string',
            'info' => 'nullable|string',
            'info_final' => 'nullable|string',
            'check_write' => 'nullable|integer|max:2|numeric',
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
