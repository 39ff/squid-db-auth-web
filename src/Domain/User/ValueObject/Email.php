<?php

declare(strict_types=1);

namespace Squidmin\Domain\User\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class Email extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('Invalid email address: %s', $value));
        }
        $this->value = strtolower($value);
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
