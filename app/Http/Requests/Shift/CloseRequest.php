<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;


class CloseRequest extends ApiRequest
{
    public function authorize()
    {
        $workShift = $this->route('workShift');
        return $workShift->active;
    }

    public function rules()
    {
        return [
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. The shift is already closed!');
    }
}
