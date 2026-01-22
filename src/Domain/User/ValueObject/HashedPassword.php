<?php

declare(strict_types=1);

namespace Squidmin\Domain\User\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class HashedPassword extends ValueObject
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromHash(string $hashedPassword): self
    {
        if (empty($hashedPassword)) {
            throw new \InvalidArgumentException('Hashed password cannot be empty');
        }
        return new self($hashedPassword);
    }

    public static function fromPlainPassword(string $plainPassword): self
    {
        if (strlen($plainPassword) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters');
        }
        return new self(password_hash($plainPassword, PASSWORD_DEFAULT));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->value);
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
