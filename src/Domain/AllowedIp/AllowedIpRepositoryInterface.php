<?php

declare(strict_types=1);

namespace Squidmin\Domain\AllowedIp;

use Squidmin\Domain\AllowedIp\ValueObject\IpAddress;
use Squidmin\Domain\Shared\RepositoryInterface;
use Squidmin\Domain\User\ValueObject\UserId;

interface AllowedIpRepositoryInterface extends RepositoryInterface
{
    public function save(AllowedIp $allowedIp): void;

    public function findById(int $id): ?AllowedIp;

    /**
     * @return AllowedIp[]
     */
    public function findByOwnerId(UserId $ownerId): array;

    /**
     * @return AllowedIp[]
     */
    public function findAll(): array;

    /**
     * @param array<string, mixed> $criteria
     * @param ?UserId $ownerId - Filter by owner (null for admin view)
     * @return AllowedIp[]
     */
    public function search(array $criteria, ?UserId $ownerId = null): array;

    public function delete(AllowedIp $allowedIp): void;

    public function existsByIpAndOwnerId(IpAddress $ipAddress, UserId $ownerId): bool;
}
