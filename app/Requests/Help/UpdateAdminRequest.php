<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|numeric|exists:category,id',
            'user_id' => 'required|integer|numeric|exists:users,id',
            'priority_id' => 'required|integer|numeric|exists:priority,id',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
