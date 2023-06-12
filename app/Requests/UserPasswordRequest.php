<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class UserPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
