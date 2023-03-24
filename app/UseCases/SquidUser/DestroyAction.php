<?php

namespace App\UseCases\SquidUser;

use App\Models\SquidUser;
use function assert;

class DestroyAction
{
    public function __invoke(SquidUser $squidUser): SquidUser
    {
        assert($squidUser->exists);
        $squidUser->delete();

        return $squidUser;
    }
}
