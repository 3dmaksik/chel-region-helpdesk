<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class ExecuteAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'info_final' => 'required|string',
            'images_final.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
