<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\SquidUser;

use Squidmin\Application\DTO\SquidUserDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;

final class GetSquidUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    public function handle(QueryInterface $query): ?SquidUserDTO
    {
        if (!$query instanceof GetSquidUserQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $squidUser = $this->squidUserRepository->findById($query->getSquidUserId());
        if ($squidUser === null) {
            return null;
        }

        return new SquidUserDTO(
            $squidUser->getId(),
            $squidUser->getUsername()->getValue(),
            $squidUser->getEnabled()->isEnabled(),
            $squidUser->getFullname()->getValue(),
            $squidUser->getComment()->getValue(),
            $squidUser->getOwnerId()->getValue(),
            $squidUser->getCreatedAt(),
            $squidUser->getUpdatedAt()
        );
    }
}
