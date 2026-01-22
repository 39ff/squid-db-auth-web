<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\Event;

use Squidmin\Domain\Shared\DomainEvent;

final class SquidUserCreated extends DomainEvent
{
    public function __construct(
        private readonly int $squidUserId,
        private readonly string $username,
        private readonly int $ownerId
    ) {
        parent::__construct();
    }

    public function getSquidUserId(): int
    {
        return $this->squidUserId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }
}
