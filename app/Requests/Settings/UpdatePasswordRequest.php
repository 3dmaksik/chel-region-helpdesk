<?php

namespace App\Requests\Settings;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', Password::min(8), 'max:255'],
            'password' => ['required', 'string', Password::min(8), 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
