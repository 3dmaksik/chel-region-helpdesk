<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PriorityRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('priority')->ignore(empty($this->priority) ? 0 : $this->priority),
            ],
            'rang' => [
                'required',
                'integer',
                'max:9',
                'numeric',
                Rule::unique('priority')->ignore(empty($this->priority) ? 0 : $this->priority),
            ],
            'color' => 'nullable|string|max:255',
            'warning_timer' => [
                'required',
                'integer',
                'min:1',
                'max:'.$this->danger_timer + 1,
                'numeric',
            ],
            'danger_timer' => [
                'required',
                'integer',
                'min: '.$this->warning_timer + 1,
                'numeric',
            ],
        ];
    }

    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
