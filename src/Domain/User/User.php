<?php

declare(strict_types=1);

namespace Squidmin\Domain\User;

use Squidmin\Domain\Shared\AggregateRoot;
use Squidmin\Domain\User\Event\UserCreated;
use Squidmin\Domain\User\Event\UserDeleted;
use Squidmin\Domain\User\Event\UserModified;
use Squidmin\Domain\User\ValueObject\AdministratorRole;
use Squidmin\Domain\User\ValueObject\Email;
use Squidmin\Domain\User\ValueObject\HashedPassword;
use Squidmin\Domain\User\ValueObject\UserName;

final class User extends AggregateRoot
{
    private UserName $name;
    private Email $email;
    private HashedPassword $password;
    private AdministratorRole $role;
    private ?\DateTimeImmutable $emailVerifiedAt;
    private ?string $rememberToken;

    private function __construct(
        int $id,
        UserName $name,
        Email $email,
        HashedPassword $password,
        AdministratorRole $role,
        ?\DateTimeImmutable $emailVerifiedAt = null,
        ?string $rememberToken = null,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->rememberToken = $rememberToken;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public static function create(
        int $id,
        UserName $name,
        Email $email,
        HashedPassword $password,
        AdministratorRole $role
    ): self {
        $user = new self($id, $name, $email, $password, $role);
        $user->recordEvent(new UserCreated($user->id, $email->getValue(), $name->getValue()));
        return $user;
    }

    public static function reconstitute(
        int $id,
        UserName $name,
        Email $email,
        HashedPassword $password,
        AdministratorRole $role,
        ?\DateTimeImmutable $emailVerifiedAt,
        ?string $rememberToken,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ): self {
        return new self(
            $id,
            $name,
            $email,
            $password,
            $role,
            $emailVerifiedAt,
            $rememberToken,
            $createdAt,
            $updatedAt
        );
    }

    public function modify(
        UserName $name,
        Email $email,
        ?HashedPassword $password = null,
        ?AdministratorRole $role = null
    ): void {
        $this->name = $name;
        $this->email = $email;
        if ($password !== null) {
            $this->password = $password;
        }
        if ($role !== null) {
            $this->role = $role;
        }
        $this->updatedAt = new \DateTimeImmutable();
        $this->recordEvent(new UserModified($this->id, $email->getValue(), $name->getValue()));
    }

    public function delete(): void
    {
        $this->recordEvent(new UserDeleted($this->id, $this->email->getValue()));
    }

    public function verifyEmail(): void
    {
        $this->emailVerifiedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setRememberToken(string $token): void
    {
        $this->rememberToken = $token;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }

    public function getRole(): AdministratorRole
    {
        return $this->role;
    }

    public function isAdministrator(): bool
    {
        return $this->role->isAdministrator();
    }

    public function getEmailVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }
}
