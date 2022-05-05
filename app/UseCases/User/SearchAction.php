<?php
namespace App\UseCases\User;

use App\Models\User;

class SearchAction{
    public function __invoke(array $query)
    {
        $users = User::query()
            ->simplePaginate($query['per'] ?? 100)
            ->withQueryString()
        ;

        return $users;

    }
}
