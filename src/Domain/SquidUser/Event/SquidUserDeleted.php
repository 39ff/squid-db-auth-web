<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\Event;

use Squidmin\Domain\Shared\DomainEvent;

final class SquidUserDeleted extends DomainEvent
{
    public function __construct(
        private readonly int $squidUserId,
        private readonly string $username
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
}
