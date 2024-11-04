<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class ExecuteAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        $fileMax = config('settings.fileMax');

        return [
            'info_final' => 'required|string',
            'images_final.*' => 'nullable', 'mimes:jpg,gif,png,jpeg', "max:$fileMax",
            'files_final.*' => 'nullable', 'mimes:arc,bz,bz2,gz,rar,tar,zip', "max:$fileMax",
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
