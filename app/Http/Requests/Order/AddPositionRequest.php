<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;

class AddPositionRequest extends ApiRequest
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
        if (!collect(['taken', 'preparing'])->contains($order->status->code)) {
            throw new ApiException(403, 'Forbidden! Cannot be added to an order with this status');
        }

        return true;
    }

    public function rules()
    {
        return [
            'menu_id' => 'required|exists:menus,id',
            'count' => 'required|integer|between:1,10'
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'menu_id.exists' => 'Item is not in the menu',
            'count.between' => 'The number of portions should be from 1 to 10'
        ];
        return $messages;
    }
}
