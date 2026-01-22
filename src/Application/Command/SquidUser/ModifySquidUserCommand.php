<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandInterface;

final class ModifySquidUserCommand implements CommandInterface
{
    public function __construct(
        private readonly int $squidUserId,
        private readonly string $username,
        private readonly string $password,
        private readonly ?string $fullname = null,
        private readonly ?string $comment = null
    ) {
    }

    public function getSquidUserId(): int
    {
        return $this->squidUserId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
