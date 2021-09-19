<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;

use App\Http\Requests\APIRequest;
use App\Models\User;

class ShiftWorkerRequest extends ApiRequest
{

    public function authorize()
    {
        $user = User::find($this->user_id);
        if (!$user) {
            return true;
        }
        return !$this->route('workShift')->hasUser($user);
    }

    public function rules()
    {
        return [
            'user_id' => ['required', function ($attribute, $value, $fail) {
                if (!User::where(['id' => $value, 'status' => 'working'])->count()) {
                    $fail('This user has been dismissed or does not exist.');
                }
            },]
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'User',
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. The worker is already on shift!');
    }
}
