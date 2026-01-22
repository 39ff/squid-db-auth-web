<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class SquidUserId extends ValueObject
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Squid User ID must be a positive integer');
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
