<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;


class RemovePositionRequest extends ApiRequest
{
    public function authorize()
    {
        $order = $this->route('order');

        if (!$order->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }

        if ($this->user()->id !== $order->user->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }

        if ($order->status->code !== 'taken') {
            throw new ApiException(403, 'Forbidden! Cannot be added to an order with this status');
        }

        return true;
    }

    public function rules()
    {
        return [

        ];
    }
}
