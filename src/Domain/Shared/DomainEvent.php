<?php

declare(strict_types=1);

namespace Squidmin\Domain\Shared;

abstract class DomainEvent
{
    protected \DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
