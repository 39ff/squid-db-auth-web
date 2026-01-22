<?php

declare(strict_types=1);

namespace Squidmin\Application\DTO;

final class AllowedIpDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $ipAddress,
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
            'ip' => $this->ipAddress,
            'user_id' => $this->ownerId,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
