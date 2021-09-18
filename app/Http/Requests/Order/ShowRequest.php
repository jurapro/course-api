<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;
use App\Models\WorkShift;

class ShowRequest extends ApiRequest
{
    public function authorize()
    {
        $order = $this->route('order');
        return $order->user->id === $this->user()->id;
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. You did not accept this order!');
    }

    public function rules()
    {
        return [

        ];
    }
}
