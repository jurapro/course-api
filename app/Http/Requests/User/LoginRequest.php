<?php

namespace App\Http\Requests\User;

use App\Http\Requests\APIRequest;
use App\Models\User;

class LoginRequest extends APIRequest
{
    public function authorize()
    {
        if ($this->login && $this->password) {
            return User::where([
                'login'=> $this->login,
                'password'=>$this->password,
                'status'=> 'working'
                ])->first();
        }
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
