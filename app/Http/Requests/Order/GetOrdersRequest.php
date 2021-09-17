<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;


class GetOrdersRequest extends ApiRequest
{
    public function authorize()
    {
        $workShift = $this->route('workShift');
        return $this->user()->hasRole(['admin']) || $workShift->hasUser($this->user()->id);
    }
    public function rules()
    {
        return [
        ];
    }
    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. You didn\'t work this shift!');
    }
}
