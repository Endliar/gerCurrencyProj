<?php

namespace App\Http\Repository;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository
{
    public function create(CreateUserRequest $request) {
        $model = new User();
        $model->name = $request['name'];
        $model->email = $request['email'];
        $model->password = Hash::make($request['password']);
        $model->save();
        return $model;
    }

    public function auth(AuthUserRequest $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = JWTAuth::fromUser($user);
            return response()->json(['accessToken' => $token], 200);
        }
        return response()->json(['Error' => 'Неверный результат'], 401);
    }

    public function searchToEmail(AuthUserRequest $request) {
        return User::where('email', $request['email'])->first();

    }

    public function isPassword(AuthUserRequest $request) {
        $model = User::where('email', $request['email'])->first();
        return Hash::check($request['password'], $model->password,) ? $model : null;
    }

}
