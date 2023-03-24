<?php

namespace App\UseCases\AllowedIp;

use App\Models\SquidAllowedIp;
use function assert;

class CreateAction
{
    public function __invoke(SquidAllowedIp $squidAllowedIp)
    {
        assert(! $squidAllowedIp->exists);
        $squidAllowedIp->save();

        return $squidAllowedIp;
    }
}
