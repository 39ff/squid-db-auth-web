<?php

declare(strict_types=1);

namespace Squidmin\Domain\AllowedIp\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class IpAddress extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException(sprintf('Invalid IP address: %s', $value));
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isIpv4(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public function isIpv6(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
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
