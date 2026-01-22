<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\AllowedIp;

use Squidmin\Application\Query\QueryInterface;

final class GetAllowedIpsByOwnerQuery implements QueryInterface
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
