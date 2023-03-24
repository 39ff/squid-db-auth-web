<?php

namespace App\Services;

use App\Models\SquidUser;

class SquidUserService
{
    public function getById($id) : SquidUser
    {
        $su = SquidUser::query()->where('id', '=', $id)->first();

        return $su ?? new SquidUser();
    }
}
