<?php

namespace App\Services;

use App\Models\SquidUser;

class SquidUserService
{
    public function getById(int|string $id): SquidUser
    {
        return SquidUser::query()->findOr($id, fn() => new SquidUser());
    }
}
