<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends BaseRequest
{
    /**
     * @return array{name: \Illuminate\Validation\Rules\Unique[]|string[], password: string, firstname: string, lastname: string, patronymic: string, cabinet_id: string, role: string}
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore(empty($this->user) ? 0 : $this->user),
            ],
            'password' => ['sometimes', 'required', 'string', Password::min(8), 'max:255'],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'cabinet_id' => 'required|integer|max:250|numeric|exists:cabinet,id',
            'role' => 'required|string|exists:roles,name',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
