<?php

namespace App\Http\Repository;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
//        if (! $token = auth()->attempt($validator->validated())) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//        return $this->createNewToken($token);
        $token = Auth::attempt($request->only('email', 'password'));
        if ($token != null) {
            return null;
        } else {
            return response()->json([
                'token' => $token
            ]);
        }
    }

    public function searchToEmail(AuthUserRequest $request) {
        return User::where('email', $request['email'])->first();
    }

    public function isPassword(AuthUserRequest $request) {
        $model = User::where('email', $request['email'])->first();
        return Hash::check($model->password, $request['password']) ? $model : null;
    }

}
