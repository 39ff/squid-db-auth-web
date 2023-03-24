<?php

namespace App\Services;

use App\Models\SquidAllowedIp;

class SquidAllowedIpService
{
    public function getById($id) : SquidAllowedIp
    {
        $ip = SquidAllowedIp::query()->where('id', '=', $id)->first();

        return $ip ?? new SquidAllowedIp();
    }
}
