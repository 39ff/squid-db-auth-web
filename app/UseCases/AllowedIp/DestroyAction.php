<?php

namespace App\UseCases\AllowedIp;

use App\Models\SquidAllowedIp;
use function assert;

class DestroyAction
{
    public function __invoke(SquidAllowedIp $squidAllowedIp)
    {
        assert($squidAllowedIp->exists);
        $squidAllowedIp->delete();

        return $squidAllowedIp;
    }
}
