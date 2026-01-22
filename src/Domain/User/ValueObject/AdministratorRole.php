<?php

declare(strict_types=1);

namespace Squidmin\Domain\User\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class AdministratorRole extends ValueObject
{
    private bool $isAdministrator;

    public function __construct(bool $isAdministrator)
    {
        $this->isAdministrator = $isAdministrator;
    }

    public function isAdministrator(): bool
    {
        return $this->isAdministrator;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->isAdministrator === $other->isAdministrator;
    }

    public function toInt(): int
    {
        return $this->isAdministrator ? 1 : 0;
    }
}
