<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\SquidUser;

use Squidmin\Application\Query\QueryInterface;

final class GetSquidUsersByOwnerQuery implements QueryInterface
{
    public function __construct(
        private readonly int $ownerId
    ) {
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }
}
