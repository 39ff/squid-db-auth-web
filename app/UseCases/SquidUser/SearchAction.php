<?php

namespace App\UseCases\SquidUser;

use App\Models\SquidUser;

class SearchAction
{
    public function __invoke(array $query)
    {
        $squidUsers = SquidUser::query()
           ->with('laravel_user')
           ->simplePaginate($query['per'] ?? 100)
           ->withQueryString();

        return $squidUsers;
    }
}
