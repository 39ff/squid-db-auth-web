<?php

declare(strict_types=1);

namespace Squidmin\Infrastructure\Persistence\Eloquent;

use App\Models\SquidUser as EloquentSquidUser;
use Squidmin\Domain\SquidUser\SquidUser;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;
use Squidmin\Domain\SquidUser\ValueObject\Comment;
use Squidmin\Domain\SquidUser\ValueObject\EnabledStatus;
use Squidmin\Domain\SquidUser\ValueObject\Fullname;
use Squidmin\Domain\SquidUser\ValueObject\SquidPassword;
use Squidmin\Domain\SquidUser\ValueObject\SquidUsername;
use Squidmin\Domain\User\ValueObject\UserId;

final class EloquentSquidUserRepository implements SquidUserRepositoryInterface
{
    public function nextIdentity(): int
    {
        return 0; // Eloquent will auto-increment
    }

    public function save(SquidUser $squidUser): void
    {
        $eloquentSquidUser = EloquentSquidUser::withoutGlobalScope('squid_user')->find($squidUser->getId());

        if ($eloquentSquidUser === null) {
            $eloquentSquidUser = new EloquentSquidUser();
        }

        $eloquentSquidUser->user = $squidUser->getUsername()->getValue();
        $eloquentSquidUser->password = $squidUser->getPassword()->getValue();
        $eloquentSquidUser->enabled = $squidUser->getEnabled()->toInt();
        $eloquentSquidUser->fullname = $squidUser->getFullname()->getValue();
        $eloquentSquidUser->comment = $squidUser->getComment()->getValue();
        $eloquentSquidUser->user_id = $squidUser->getOwnerId()->getValue();

        $eloquentSquidUser->save();

        // Update the SquidUser entity with the new ID if it was just created
        if ($squidUser->getId() === 0) {
            $reflection = new \ReflectionClass($squidUser);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($squidUser, $eloquentSquidUser->id);
        }
    }

    public function findById(int $id): ?SquidUser
    {
        $eloquentSquidUser = EloquentSquidUser::withoutGlobalScope('squid_user')->find($id);
        if ($eloquentSquidUser === null) {
            return null;
        }

        return $this->toDomain($eloquentSquidUser);
    }

    public function findByUsername(SquidUsername $username): ?SquidUser
    {
        $eloquentSquidUser = EloquentSquidUser::withoutGlobalScope('squid_user')
            ->where('user', $username->getValue())
            ->first();

        if ($eloquentSquidUser === null) {
            return null;
        }

        return $this->toDomain($eloquentSquidUser);
    }

    public function findByOwnerId(UserId $ownerId): array
    {
        $eloquentSquidUsers = EloquentSquidUser::withoutGlobalScope('squid_user')
            ->where('user_id', $ownerId->getValue())
            ->get();

        return $eloquentSquidUsers->map(fn($eloquentSquidUser) => $this->toDomain($eloquentSquidUser))->all();
    }

    public function findAll(): array
    {
        $eloquentSquidUsers = EloquentSquidUser::withoutGlobalScope('squid_user')->get();
        return $eloquentSquidUsers->map(fn($eloquentSquidUser) => $this->toDomain($eloquentSquidUser))->all();
    }

    public function search(array $criteria, ?UserId $ownerId = null): array
    {
        $query = EloquentSquidUser::withoutGlobalScope('squid_user');

        if ($ownerId !== null) {
            $query->where('user_id', $ownerId->getValue());
        }

        foreach ($criteria as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        $eloquentSquidUsers = $query->get();
        return $eloquentSquidUsers->map(fn($eloquentSquidUser) => $this->toDomain($eloquentSquidUser))->all();
    }

    public function delete(SquidUser $squidUser): void
    {
        EloquentSquidUser::withoutGlobalScope('squid_user')->destroy($squidUser->getId());
    }

    public function existsByUsername(SquidUsername $username): bool
    {
        return EloquentSquidUser::withoutGlobalScope('squid_user')
            ->where('user', $username->getValue())
            ->exists();
    }

    private function toDomain(EloquentSquidUser $eloquentSquidUser): SquidUser
    {
        return SquidUser::reconstitute(
            $eloquentSquidUser->id,
            new SquidUsername($eloquentSquidUser->user),
            new SquidPassword($eloquentSquidUser->password),
            new EnabledStatus((bool) $eloquentSquidUser->enabled),
            new Fullname($eloquentSquidUser->fullname),
            new Comment($eloquentSquidUser->comment),
            new UserId($eloquentSquidUser->user_id),
            new \DateTimeImmutable($eloquentSquidUser->created_at),
            new \DateTimeImmutable($eloquentSquidUser->updated_at)
        );
    }
}
