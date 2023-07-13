<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CabinetRequest extends BaseRequest
{
    /**
     * @return array{description: \Illuminate\Validation\Rules\Unique[]|string[]}
     */
    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'integer',
                'numeric',
                'min:1',
                'max:999',
                Rule::unique('cabinet')->ignore(empty($this->cabinet) ? 0 : $this->cabinet),
            ],

        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
