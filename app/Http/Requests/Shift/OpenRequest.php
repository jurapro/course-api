<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;
use App\Models\WorkShift;

class OpenRequest extends ApiRequest
{
    public function authorize()
    {
        if (WorkShift::where(['active' => true])->count()) {
            return false;
        }

        return true;
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. There are open shifts!');
    }
}
