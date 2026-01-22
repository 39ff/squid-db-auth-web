<?php

declare(strict_types=1);

namespace Squidmin\Application\DTO;

final class SquidUserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly bool $enabled,
        public readonly ?string $fullname,
        public readonly ?string $comment,
        public readonly int $ownerId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user' => $this->username,
            'enabled' => $this->enabled ? 1 : 0,
            'fullname' => $this->fullname,
            'comment' => $this->comment,
            'user_id' => $this->ownerId,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
