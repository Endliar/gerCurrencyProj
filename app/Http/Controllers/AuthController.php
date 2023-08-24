<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth: api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
        if ($validator->fails()) {
            return response() -> json($validator->errors(), 422);
        }
        if (! $token = auth() -> attempt($validator->validated())) {
            return response() -> json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(CreateUserRequest $request, UserService $service) {
        $request->validated();
        return $service->register($request);
    }

    public function logout() {
        auth() -> logout();
        return response() -> json(['message' => 'User successfully signed out!']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        return response() -> json(auth()->user());
    }

    public function createNewToken($token) {
        return response() -> json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
