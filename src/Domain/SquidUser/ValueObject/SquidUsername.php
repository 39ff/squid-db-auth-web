<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class SquidUsername extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Squid username cannot be empty');
        }
        if (strlen($value) > 255) {
            throw new \InvalidArgumentException('Squid username cannot exceed 255 characters');
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
