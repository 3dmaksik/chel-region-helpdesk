<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class NewsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'news_text' => 'required|string',
            'created_at' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
