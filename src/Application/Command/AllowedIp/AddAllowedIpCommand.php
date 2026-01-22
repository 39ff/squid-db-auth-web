<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\AllowedIp;

use Squidmin\Application\Command\CommandInterface;

final class AddAllowedIpCommand implements CommandInterface
{
    public function __construct(
        private readonly string $ipAddress,
        private readonly int $ownerId
    ) {
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }
}
