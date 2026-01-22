<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\AllowedIp;

use Squidmin\Application\Command\CommandInterface;

final class RemoveAllowedIpCommand implements CommandInterface
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
