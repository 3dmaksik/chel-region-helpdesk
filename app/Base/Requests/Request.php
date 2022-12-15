<?php

namespace App\Base\Requests;

use App\Core\Requests\CoreRequest;

abstract class Request extends CoreRequest
{
    public function authorize()
    {
        //return auth()->check();
       // return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
