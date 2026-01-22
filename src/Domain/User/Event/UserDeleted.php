<?php

declare(strict_types=1);

namespace Squidmin\Domain\User\Event;

use Squidmin\Domain\Shared\DomainEvent;

final class UserDeleted extends DomainEvent
{
    public function __construct(
        private readonly int $userId,
        private readonly string $email
    ) {
        parent::__construct();
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
