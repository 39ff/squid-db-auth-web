<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\SquidUser;

use Squidmin\Application\Query\QueryInterface;

final class SearchSquidUsersQuery implements QueryInterface
{
    /**
     * @param array<string, mixed> $criteria
     */
    public function __construct(
        private readonly array $criteria,
        private readonly ?int $ownerId = null
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }
}
