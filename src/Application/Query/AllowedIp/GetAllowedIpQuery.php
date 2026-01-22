<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\AllowedIp;

use Squidmin\Application\Query\QueryInterface;

final class GetAllowedIpQuery implements QueryInterface
{
    public function __construct(
        private readonly int $allowedIpId
    ) {
    }

    public function getAllowedIpId(): int
    {
        return $this->allowedIpId;
    }
}
