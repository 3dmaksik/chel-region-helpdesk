<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CabinetRequest extends BaseRequest
{
    //Правила валидации
    public function rules(): array
    {
        return [
             'description' => [
                'required',
                'integer',
                'numeric',
                'max:250',
                Rule::unique('cabinet')->ignore(empty($this->cabinet) ? 0 : $this->cabinet),
             ],

        ];
    }
    //Проверка авторизации
    public function authorize(): bool
    {
        return Auth::check();
    }
}
