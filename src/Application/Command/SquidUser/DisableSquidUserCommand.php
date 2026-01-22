<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandInterface;

final class DisableSquidUserCommand implements CommandInterface
{
    public function __construct(
        private readonly int $squidUserId
    ) {
    }

    public function getSquidUserId(): int
    {
        return $this->squidUserId;
    }
}
