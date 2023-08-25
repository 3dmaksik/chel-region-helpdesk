<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;

class SearchUserRequest extends BaseRequest
{
    /**
     * @return array{q: string}
     */
    public function rules(): array
    {
        return [
            'q' => 'sometimes|required|string|min:1|max:255',
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
