<?php

namespace App\Http\Services;

use App\Http\Repository\UserRepository;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\CreateUserRequest;

class UserService
{
    protected UserRepository $repository;
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function login(AuthUserRequest $context) {
        if ($user = $this->repository->searchToEmail($context)) {
            if ($this->repository->isPassword($context)) {
                return $this->repository->auth($context, $user);
            } else {
                return response('Пароль неверен');
            }
        } else {
            return response('Такого пользователя не существует');
        }
    }

    public function register(CreateUserRequest $context) {
        return $this->repository->create($context);
    }
}
