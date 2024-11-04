<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;

class IndexUserRequest extends BaseRequest
{
    public function rules(): array
    {
        $fileMax = config('settings.fileMax');

        return [
            'category_id' => 'required|exists:category,id',
            'user_id' => 'required|exists:users,id',
            'images.*' => 'nullable', 'mimes:jpg,gif,png,jpeg', "max:$fileMax",
            'files.*' => 'nullable', 'mimes:arc,bz,bz2,gz,rar,tar,zip', "max:$fileMax",
            'description_long' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
