<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class AcceptAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'executor_id' => 'required|integer|numeric|exists:users,id',
            'priority_id' => 'required|integer|numeric|exists:priority,id',
            'info' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
