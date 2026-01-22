<?php

declare(strict_types=1);

namespace Squidmin\Domain\Shared;

abstract class ValueObject
{
    abstract public function equals(ValueObject $other): bool;
}
