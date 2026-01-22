<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\User;

use Squidmin\Application\DTO\UserDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\User\UserRepositoryInterface;

final class GetUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(QueryInterface $query): ?UserDTO
    {
        if (!$query instanceof GetUserQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $user = $this->userRepository->findById($query->getUserId());
        if ($user === null) {
            return null;
        }

        return new UserDTO(
            $user->getId(),
            $user->getName()->getValue(),
            $user->getEmail()->getValue(),
            $user->isAdministrator(),
            $user->getEmailVerifiedAt(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }
}
