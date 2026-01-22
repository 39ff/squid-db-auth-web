<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandInterface;

final class CreateSquidUserCommand implements CommandInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly int $ownerId,
        private readonly ?string $fullname = null,
        private readonly ?string $comment = null
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
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
