<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;
use App\Models\WorkShift;

class OpenRequest extends ApiRequest
{
    public function authorize()
    {
        return !WorkShift::where(['active' => true])->first();
    }

    public function rules()
    {
        return [
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. There are open shifts!');
    }
}
