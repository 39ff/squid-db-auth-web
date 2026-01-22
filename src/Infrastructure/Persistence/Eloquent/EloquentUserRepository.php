<?php

declare(strict_types=1);

namespace Squidmin\Infrastructure\Persistence\Eloquent;

use App\Models\User as EloquentUser;
use Squidmin\Domain\User\User;
use Squidmin\Domain\User\UserRepositoryInterface;
use Squidmin\Domain\User\ValueObject\AdministratorRole;
use Squidmin\Domain\User\ValueObject\Email;
use Squidmin\Domain\User\ValueObject\HashedPassword;
use Squidmin\Domain\User\ValueObject\UserName;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function nextIdentity(): int
    {
        return 0; // Eloquent will auto-increment
    }

    public function save(User $user): void
    {
        $eloquentUser = EloquentUser::find($user->getId());

        if ($eloquentUser === null) {
            $eloquentUser = new EloquentUser();
        }

        $eloquentUser->name = $user->getName()->getValue();
        $eloquentUser->email = $user->getEmail()->getValue();
        $eloquentUser->password = $user->getPassword()->getValue();
        $eloquentUser->is_administrator = $user->getRole()->toInt();

        if ($user->getEmailVerifiedAt() !== null) {
            $eloquentUser->email_verified_at = $user->getEmailVerifiedAt()->format('Y-m-d H:i:s');
        }

        if ($user->getRememberToken() !== null) {
            $eloquentUser->remember_token = $user->getRememberToken();
        }

        $eloquentUser->save();

        // Update the User entity with the new ID if it was just created
        if ($user->getId() === 0) {
            $reflection = new \ReflectionClass($user);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($user, $eloquentUser->id);
        }
    }

    public function findById(int $id): ?User
    {
        $eloquentUser = EloquentUser::find($id);
        if ($eloquentUser === null) {
            return null;
        }

        return $this->toDomain($eloquentUser);
    }

    public function findByEmail(Email $email): ?User
    {
        $eloquentUser = EloquentUser::where('email', $email->getValue())->first();
        if ($eloquentUser === null) {
            return null;
        }

        return $this->toDomain($eloquentUser);
    }

    public function findAll(): array
    {
        $eloquentUsers = EloquentUser::all();
        return $eloquentUsers->map(fn($eloquentUser) => $this->toDomain($eloquentUser))->all();
    }

    public function search(array $criteria): array
    {
        $query = EloquentUser::query();

        foreach ($criteria as $field => $value) {
            $query->where($field, 'like', "%{$value}%");
        }

        $eloquentUsers = $query->get();
        return $eloquentUsers->map(fn($eloquentUser) => $this->toDomain($eloquentUser))->all();
    }

    public function delete(User $user): void
    {
        EloquentUser::destroy($user->getId());
    }

    public function existsByEmail(Email $email): bool
    {
        return EloquentUser::where('email', $email->getValue())->exists();
    }

    private function toDomain(EloquentUser $eloquentUser): User
    {
        return User::reconstitute(
            $eloquentUser->id,
            new UserName($eloquentUser->name),
            new Email($eloquentUser->email),
            HashedPassword::fromHash($eloquentUser->password),
            new AdministratorRole((bool) $eloquentUser->is_administrator),
            $eloquentUser->email_verified_at ? new \DateTimeImmutable($eloquentUser->email_verified_at) : null,
            $eloquentUser->remember_token,
            new \DateTimeImmutable($eloquentUser->created_at),
            new \DateTimeImmutable($eloquentUser->updated_at)
        );
    }
}
