<?php

namespace App\Services;

use App\Models\SquidAllowedIp;

class SquidAllowedIpService
{
    public function getById(int|string $id): SquidAllowedIp
    {
        return SquidAllowedIp::query()->findOr($id, fn() => new SquidAllowedIp());
    }
}
