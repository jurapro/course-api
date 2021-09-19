<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends ApiRequest
{

    public function authorize()
    {
        $order = $this->route('order');

        if (!$order->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }
        if (!$this->user()->hasRole(['cook']) && $order->user->id !== $this->user()->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }
        if (!$order->getAllowedsTransitions($this->user())->contains($this->status)) {
            throw new ApiException(403, 'Forbidden! Can\'t change existing order status');
        }

        return true;
    }

    public function rules()
    {
        return [
            'status' => ['required',
                Rule::in(['taken', 'preparing', 'ready', 'paid-up', 'canceled'])]
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'in' => 'Status can only be: taken, preparing, ready, paid-up, canceled'
        ];
        return $messages;
    }
}
