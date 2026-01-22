<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        private readonly int $userId
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
