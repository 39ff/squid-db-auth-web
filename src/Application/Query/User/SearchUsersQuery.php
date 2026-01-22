<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\User;

use Squidmin\Application\Query\QueryInterface;

final class SearchUsersQuery implements QueryInterface
{
    /**
     * @param array<string, mixed> $criteria
     */
    public function __construct(
        private readonly array $criteria
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }
}
