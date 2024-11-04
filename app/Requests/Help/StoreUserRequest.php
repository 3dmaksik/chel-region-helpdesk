<?php

namespace App\Requests\Help;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends BaseRequest
{
    public function rules(): array
    {
        $fileMax = config('settings.fileMax');

        return [
            'category_id' => 'required|integer|numeric|exists:category,id',
            'description_long' => 'required|string',
            'images.*' => 'nullable|mimes:jpg,gif,png,jpeg|max:'.$fileMax.'',
            'files.*' => 'nullable|mimes:arc,bz,bz2,gz,rar,tar,zip|max:'.$fileMax.'',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
