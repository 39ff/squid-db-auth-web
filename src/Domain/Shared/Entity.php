<?php

declare(strict_types=1);

namespace Squidmin\Domain\Shared;

abstract class Entity
{
    protected int $id;
    protected \DateTimeImmutable $createdAt;
    protected \DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function equals(Entity $other): bool
    {
        return $this->id === $other->id && get_class($this) === get_class($other);
    }
}
