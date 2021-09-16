<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
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
        return UserResource::collection(User::all());
    }

    public function store(AddRequest $userRequest)
    {
        $user = User::create([
                'photo_file' => $userRequest->photo_file ? $userRequest->photo_file->store('public') : null,
            ] + $userRequest->all()
        );

        return response()->json([
            'data' => [
                'id' => $user->id,
                'status' => 'created'
            ]
        ])->setStatusCode(201, 'Created');
    }

}
