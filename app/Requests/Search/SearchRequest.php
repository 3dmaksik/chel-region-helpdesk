<?php

namespace App\Requests\Search;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class SearchRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'search' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
