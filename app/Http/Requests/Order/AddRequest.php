<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\APIRequest;
use App\Models\WorkShift;

class AddRequest extends ApiRequest
{
    public function authorize()
    {
        $workShift = WorkShift::find($this->work_shift_id);

        if (!$workShift->active) {
            throw new ApiException(403, 'Forbidden. The shift must be active!');
        };

        if (!$workShift->hasUser($this->user())) {
            throw new ApiException(403, 'Forbidden. You don\'t work this shift!');
        }

        return true;
    }

    public function rules()
    {
        return [
            'work_shift_id' => 'required|exists:work_shifts,id',
            'table_id' => 'required|exists:tables,id',
            'number_of_person' => 'integer'
        ];
    }
}
