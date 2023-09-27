<?php

namespace App\Requests\Search;

use App\Base\Requests\Request as BaseRequest;

class SearchUserPublicRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'q' => 'sometimes|required|string|min:1|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
