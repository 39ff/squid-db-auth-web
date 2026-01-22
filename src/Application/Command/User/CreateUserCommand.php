<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly bool $isAdministrator
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isAdministrator(): bool
    {
        return $this->isAdministrator;
    }
}
