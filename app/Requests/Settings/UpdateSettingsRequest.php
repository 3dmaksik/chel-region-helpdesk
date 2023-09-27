<?php

namespace App\Requests\Settings;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSettingsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'avatar' => 'nullable|mimes:jpg,gif,png,jpeg|max:20480',
            'sound_notify' => 'nullable|mimes:opus,oga,ogg|max:20480',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
