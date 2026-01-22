<?php

declare(strict_types=1);

namespace Squidmin\Domain\User;

use Squidmin\Domain\Shared\RepositoryInterface;
use Squidmin\Domain\User\ValueObject\Email;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): void;

    public function findById(int $id): ?User;

    public function findByEmail(Email $email): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param array<string, mixed> $criteria
     * @return User[]
     */
    public function search(array $criteria): array;

    public function delete(User $user): void;

    public function existsByEmail(Email $email): bool;
}
