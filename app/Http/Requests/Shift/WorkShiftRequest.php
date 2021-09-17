<?php

namespace App\Http\Requests\Shift;
use App\Http\Requests\APIRequest;

class WorkShiftRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => 'required|date_format:Y-m-d H:i|after_or_equal:now',
            'end' => 'required|date_format:Y-m-d H:i|after:start',
        ];
    }
}
