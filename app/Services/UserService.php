<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getById(int|string $id): User
    {
        return User::query()->findOr($id, fn() => new User());
    }
}
