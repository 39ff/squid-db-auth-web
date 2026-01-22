<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser\ValueObject;

use Squidmin\Domain\Shared\ValueObject;

final class EnabledStatus extends ValueObject
{
    private bool $enabled;

    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function enable(): self
    {
        return new self(true);
    }

    public function disable(): self
    {
        return new self(false);
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->enabled === $other->enabled;
    }

    public function toInt(): int
    {
        return $this->enabled ? 1 : 0;
    }
}
