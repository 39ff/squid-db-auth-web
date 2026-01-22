<?php

declare(strict_types=1);

namespace Squidmin\Domain\User\Event;

use Squidmin\Domain\Shared\DomainEvent;

final class UserCreated extends DomainEvent
{
    public function __construct(
        private readonly int $userId,
        private readonly string $email,
        private readonly string $name
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

    public function getName(): string
    {
        return $this->name;
    }
}
