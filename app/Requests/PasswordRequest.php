<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class PasswordRequest extends BaseRequest
{
    /**
     * @return array{current_password: string, password: string}
     */
    public function rules(): array
    {
        return [
            'current_password' => 'sometimes|required|string|min:4|max:255',
            'password' => 'required|string|min:4|max:255',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
