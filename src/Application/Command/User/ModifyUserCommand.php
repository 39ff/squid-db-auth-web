<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandInterface;

final class ModifyUserCommand implements CommandInterface
{
    public function __construct(
        private readonly int $userId,
        private readonly string $name,
        private readonly string $email,
        private readonly ?string $password = null,
        private readonly ?bool $isAdministrator = null
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function isAdministrator(): ?bool
    {
        return $this->isAdministrator;
    }
}
