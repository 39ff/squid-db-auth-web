<?php

namespace App\UseCases\AllowedIp;

use App\Models\SquidAllowedIp;

class SearchAction
{
    public function __invoke(array $query)
    {
        $ips = SquidAllowedIp::query()
            ->with('laravel_user')
            ->simplePaginate($query['per'] ?? 100)
            ->withQueryString();

        return $ips;
    }
}
