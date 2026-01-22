<?php

declare(strict_types=1);

namespace Squidmin\Infrastructure\Persistence\Eloquent;

use App\Models\SquidAllowedIp as EloquentSquidAllowedIp;
use Squidmin\Domain\AllowedIp\AllowedIp;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;
use Squidmin\Domain\AllowedIp\ValueObject\IpAddress;
use Squidmin\Domain\User\ValueObject\UserId;

final class EloquentAllowedIpRepository implements AllowedIpRepositoryInterface
{
    public function nextIdentity(): int
    {
        return 0; // Eloquent will auto-increment
    }

    public function save(AllowedIp $allowedIp): void
    {
        $eloquentAllowedIp = EloquentSquidAllowedIp::withoutGlobalScope('squid_user')->find($allowedIp->getId());

        if ($eloquentAllowedIp === null) {
            $eloquentAllowedIp = new EloquentSquidAllowedIp();
        }

        $eloquentAllowedIp->ip = $allowedIp->getIpAddress()->getValue();
        $eloquentAllowedIp->user_id = $allowedIp->getOwnerId()->getValue();

        $eloquentAllowedIp->save();

        // Update the AllowedIp entity with the new ID if it was just created
        if ($allowedIp->getId() === 0) {
            $reflection = new \ReflectionClass($allowedIp);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($allowedIp, $eloquentAllowedIp->id);
        }
    }

    public function findById(int $id): ?AllowedIp
    {
        $eloquentAllowedIp = EloquentSquidAllowedIp::withoutGlobalScope('squid_user')->find($id);
        if ($eloquentAllowedIp === null) {
            return null;
        }

        return $this->toDomain($eloquentAllowedIp);
    }

    public function findByOwnerId(UserId $ownerId): array
    {
        $eloquentAllowedIps = EloquentSquidAllowedIp::withoutGlobalScope('squid_user')
            ->where('user_id', $ownerId->getValue())
            ->get();

        return $eloquentAllowedIps->map(fn($eloquentAllowedIp) => $this->toDomain($eloquentAllowedIp))->all();
    }

    public function findAll(): array
    {
        $eloquentAllowedIps = EloquentSquidAllowedIp::withoutGlobalScope('squid_user')->get();
        return $eloquentAllowedIps->map(fn($eloquentAllowedIp) => $this->toDomain($eloquentAllowedIp))->all();
    }

    public function search(array $criteria, ?UserId $ownerId = null): array
    {
        $query = EloquentSquidAllowedIp::withoutGlobalScope('squid_user');

        if ($ownerId !== null) {
            $query->where('user_id', $ownerId->getValue());
        }

        foreach ($criteria as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        $eloquentAllowedIps = $query->get();
        return $eloquentAllowedIps->map(fn($eloquentAllowedIp) => $this->toDomain($eloquentAllowedIp))->all();
    }

    public function delete(AllowedIp $allowedIp): void
    {
        EloquentSquidAllowedIp::withoutGlobalScope('squid_user')->destroy($allowedIp->getId());
    }

    public function existsByIpAndOwnerId(IpAddress $ipAddress, UserId $ownerId): bool
    {
        return EloquentSquidAllowedIp::withoutGlobalScope('squid_user')
            ->where('ip', $ipAddress->getValue())
            ->where('user_id', $ownerId->getValue())
            ->exists();
    }

    private function toDomain(EloquentSquidAllowedIp $eloquentAllowedIp): AllowedIp
    {
        return AllowedIp::reconstitute(
            $eloquentAllowedIp->id,
            new IpAddress($eloquentAllowedIp->ip),
            new UserId($eloquentAllowedIp->user_id),
            new \DateTimeImmutable($eloquentAllowedIp->created_at),
            new \DateTimeImmutable($eloquentAllowedIp->updated_at)
        );
    }
}
