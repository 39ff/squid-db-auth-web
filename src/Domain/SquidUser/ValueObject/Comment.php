<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class Comment extends ValueObject
{
    private ?string $value;

    public function __construct(?string $value)
    {
        if ($value !== null && strlen($value) > 1000) {
            throw new \InvalidArgumentException('Comment cannot exceed 1000 characters');
        }
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }
}
