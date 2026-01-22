<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser;

use Squidmin\Domain\Shared\RepositoryInterface;
use Squidmin\Domain\SquidUser\ValueObject\SquidUsername;
use Squidmin\Domain\User\ValueObject\UserId;

interface SquidUserRepositoryInterface extends RepositoryInterface
{
    public function save(SquidUser $squidUser): void;

    public function findById(int $id): ?SquidUser;

    public function findByUsername(SquidUsername $username): ?SquidUser;

    /**
     * @return SquidUser[]
     */
    public function findByOwnerId(UserId $ownerId): array;

    /**
     * @return SquidUser[]
     */
    public function findAll(): array;

    /**
     * @param array<string, mixed> $criteria
     * @param ?UserId $ownerId - Filter by owner (null for admin view)
     * @return SquidUser[]
     */
    public function search(array $criteria, ?UserId $ownerId = null): array;

    public function delete(SquidUser $squidUser): void;

    public function existsByUsername(SquidUsername $username): bool;
}
