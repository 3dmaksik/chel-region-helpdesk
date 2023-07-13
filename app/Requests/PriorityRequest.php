<?php

namespace App\Requests;

use App\Base\Requests\Request as BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PriorityRequest extends BaseRequest
{
    /**
     * @return array{description: \Illuminate\Validation\Rules\Unique[]|string[], rang: \Illuminate\Validation\Rules\Unique[]|string[], warning_timer: mixed[], danger_timer: mixed[]}
     */
    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'string',
                'max:255',
                Rule::unique('priority')->ignore(empty($this->priority) ? 0 : $this->priority),
            ],
            'rang' => [
                'required',
                'integer',
                'numeric',
                'max:9',
                Rule::unique('priority')->ignore(empty($this->priority) ? 0 : $this->priority),
            ],
            'warning_timer' => [
                'required',
                'integer',
                'numeric',
                'min:1',
                'max:'.(int) $this->danger_timer + 1,
            ],
            'danger_timer' => [
                'required',
                'integer',
                'numeric',
                'min: '.(int) $this->warning_timer + 1,
            ],
        ];
    }

    public function authorize(): bool
    {
        return Auth::check();
    }
}
