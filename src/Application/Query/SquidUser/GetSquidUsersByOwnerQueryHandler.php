<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\SquidUser;

use Squidmin\Application\DTO\SquidUserDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;
use Squidmin\Domain\User\ValueObject\UserId;

final class GetSquidUsersByOwnerQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    /**
     * @return SquidUserDTO[]
     */
    public function handle(QueryInterface $query): array
    {
        if (!$query instanceof GetSquidUsersByOwnerQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $squidUsers = $this->squidUserRepository->findByOwnerId(new UserId($query->getOwnerId()));

        return array_map(function ($squidUser) {
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
        }, $squidUsers);
    }
}
