<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getById($id) : User
    {
        $user = User::query()->where('id', '=', $id)->first();

        return $user ?? new User();
    }
}
