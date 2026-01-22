<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class SquidPassword extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Squid password cannot be empty');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
