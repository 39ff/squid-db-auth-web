<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\SquidUser;

use Squidmin\Application\Query\QueryInterface;

final class GetSquidUserQuery implements QueryInterface
{
    public function __construct(
        private readonly int $squidUserId
    ) {
    }

    public function getSquidUserId(): int
    {
        return $this->squidUserId;
    }
}
