<?php

declare(strict_types=1);

namespace Squidmin\Domain\AllowedIp\Event;

use Squidmin\Domain\Shared\DomainEvent;

final class AllowedIpAdded extends DomainEvent
{
    public function __construct(
        private readonly int $allowedIpId,
        private readonly string $ipAddress,
        private readonly int $ownerId
    ) {
        parent::__construct();
    }

    public function getAllowedIpId(): int
    {
        return $this->allowedIpId;
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
