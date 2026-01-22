<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\User;

use Squidmin\Application\Query\QueryInterface;

final class GetUserQuery implements QueryInterface
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
