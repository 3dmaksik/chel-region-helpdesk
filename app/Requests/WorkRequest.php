<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WorkRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
             'firstname' => 'required|string|max:256',
             'lastname' => 'required|string|max:256',
             'patronymic' => 'nullable|string|max:256',
             'cabinet_id' => 'required|integer|max:9999|numeric|exists:cabinet,id',
             'user_id' => [
                'required',
                'integer',
                'max:9999',
                'numeric',
                'exists:users,id',
                Rule::unique('work')->ignore(empty($this->work) ? 0 : $this->work),
             ],
        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
