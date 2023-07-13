<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
{
    /**
     * @return array{description: \Illuminate\Validation\Rules\Unique[]|string[]}
     */
    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category')->ignore(empty($this->caregory) ? 0 : $this->category),
            ],
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
