<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        return [
            'data' => [
                'user_token' => User::where(['login' => $request->login])->first()->generateToken()
            ]
        ];
    }

    public function logout()
    {
        Auth::user()->logout();
        return [
            'data' => [
                'message' => 'logout'
            ]
        ];
    }

    public function index()
    {

    }

    public function store()
    {

    }

}
