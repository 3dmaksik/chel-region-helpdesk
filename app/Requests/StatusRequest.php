<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StatusRequest extends BaseRequest
{
    /**
     * @return array{description: \Illuminate\Validation\Rules\Unique[]|string[], color: \Illuminate\Validation\Rules\Unique[]|string[]}
     */
    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('status')->ignore(empty($this->status) ? 0 : $this->status),
            ],
            'color' => [
                'required',
                'string',
                'max:255',
                Rule::unique('status')->ignore(empty($this->status) ? 0 : $this->status),
            ],
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
