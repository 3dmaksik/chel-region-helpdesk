<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class RejectAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'info_final' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
