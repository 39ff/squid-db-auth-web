<?php

declare(strict_types=1);

namespace Squidmin\Domain\AllowedIp;

use Squidmin\Domain\AllowedIp\Event\AllowedIpAdded;
use Squidmin\Domain\AllowedIp\Event\AllowedIpRemoved;
use Squidmin\Domain\AllowedIp\ValueObject\IpAddress;
use Squidmin\Domain\Shared\AggregateRoot;
use Squidmin\Domain\User\ValueObject\UserId;

final class AllowedIp extends AggregateRoot
{
    private IpAddress $ipAddress;
    private UserId $ownerId;

    private function __construct(
        int $id,
        IpAddress $ipAddress,
        UserId $ownerId,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->ipAddress = $ipAddress;
        $this->ownerId = $ownerId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public static function add(
        int $id,
        IpAddress $ipAddress,
        UserId $ownerId
    ): self {
        $allowedIp = new self($id, $ipAddress, $ownerId);
        $allowedIp->recordEvent(
            new AllowedIpAdded($allowedIp->id, $ipAddress->getValue(), $ownerId->getValue())
        );
        return $allowedIp;
    }

    public static function reconstitute(
        int $id,
        IpAddress $ipAddress,
        UserId $ownerId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ): self {
        return new self(
            $id,
            $ipAddress,
            $ownerId,
            $createdAt,
            $updatedAt
        );
    }

    public function remove(): void
    {
        $this->recordEvent(new AllowedIpRemoved($this->id, $this->ipAddress->getValue()));
    }

    public function isOwnedBy(UserId $userId): bool
    {
        return $this->ownerId->equals($userId);
    }

    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    public function getOwnerId(): UserId
    {
        return $this->ownerId;
    }
}
