<?php

declare(strict_types=1);

namespace Squidmin\Domain\SquidUser;

use Squidmin\Domain\Shared\AggregateRoot;
use Squidmin\Domain\SquidUser\Event\SquidUserCreated;
use Squidmin\Domain\SquidUser\Event\SquidUserDeleted;
use Squidmin\Domain\SquidUser\Event\SquidUserDisabled;
use Squidmin\Domain\SquidUser\Event\SquidUserEnabled;
use Squidmin\Domain\SquidUser\Event\SquidUserModified;
use Squidmin\Domain\SquidUser\ValueObject\Comment;
use Squidmin\Domain\SquidUser\ValueObject\EnabledStatus;
use Squidmin\Domain\SquidUser\ValueObject\Fullname;
use Squidmin\Domain\SquidUser\ValueObject\SquidPassword;
use Squidmin\Domain\SquidUser\ValueObject\SquidUsername;
use Squidmin\Domain\User\ValueObject\UserId;

final class SquidUser extends AggregateRoot
{
    private SquidUsername $username;
    private SquidPassword $password;
    private EnabledStatus $enabled;
    private Fullname $fullname;
    private Comment $comment;
    private UserId $ownerId;

    private function __construct(
        int $id,
        SquidUsername $username,
        SquidPassword $password,
        EnabledStatus $enabled,
        Fullname $fullname,
        Comment $comment,
        UserId $ownerId,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->enabled = $enabled;
        $this->fullname = $fullname;
        $this->comment = $comment;
        $this->ownerId = $ownerId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public static function create(
        int $id,
        SquidUsername $username,
        SquidPassword $password,
        UserId $ownerId,
        ?Fullname $fullname = null,
        ?Comment $comment = null
    ): self {
        $squidUser = new self(
            $id,
            $username,
            $password,
            new EnabledStatus(true),
            $fullname ?? new Fullname(null),
            $comment ?? new Comment(null),
            $ownerId
        );
        $squidUser->recordEvent(
            new SquidUserCreated($squidUser->id, $username->getValue(), $ownerId->getValue())
        );
        return $squidUser;
    }

    public static function reconstitute(
        int $id,
        SquidUsername $username,
        SquidPassword $password,
        EnabledStatus $enabled,
        Fullname $fullname,
        Comment $comment,
        UserId $ownerId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ): self {
        return new self(
            $id,
            $username,
            $password,
            $enabled,
            $fullname,
            $comment,
            $ownerId,
            $createdAt,
            $updatedAt
        );
    }

    public function modify(
        SquidUsername $username,
        SquidPassword $password,
        ?Fullname $fullname = null,
        ?Comment $comment = null
    ): void {
        $this->username = $username;
        $this->password = $password;
        if ($fullname !== null) {
            $this->fullname = $fullname;
        }
        if ($comment !== null) {
            $this->comment = $comment;
        }
        $this->updatedAt = new \DateTimeImmutable();
        $this->recordEvent(new SquidUserModified($this->id, $username->getValue()));
    }

    public function enable(): void
    {
        if ($this->enabled->isEnabled()) {
            return;
        }
        $this->enabled = $this->enabled->enable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->recordEvent(new SquidUserEnabled($this->id, $this->username->getValue()));
    }

    public function disable(): void
    {
        if (!$this->enabled->isEnabled()) {
            return;
        }
        $this->enabled = $this->enabled->disable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->recordEvent(new SquidUserDisabled($this->id, $this->username->getValue()));
    }

    public function delete(): void
    {
        $this->recordEvent(new SquidUserDeleted($this->id, $this->username->getValue()));
    }

    public function isOwnedBy(UserId $userId): bool
    {
        return $this->ownerId->equals($userId);
    }

    public function getUsername(): SquidUsername
    {
        return $this->username;
    }

    public function getPassword(): SquidPassword
    {
        return $this->password;
    }

    public function getEnabled(): EnabledStatus
    {
        return $this->enabled;
    }

    public function getFullname(): Fullname
    {
        return $this->fullname;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getOwnerId(): UserId
    {
        return $this->ownerId;
    }
}
