<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
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

    public function show()
    {

    }

    public function store()
    {

    }

}
