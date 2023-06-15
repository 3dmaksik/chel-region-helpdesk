<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class PasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
