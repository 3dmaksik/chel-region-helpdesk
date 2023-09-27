<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class RedefineAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'executor_id' => 'required|integer|numeric|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
