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
        if ($this->repository->searchToEmail($context)) {
            if ($this->repository->isPassword($context)) {
                return $this->repository->auth($context);
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
