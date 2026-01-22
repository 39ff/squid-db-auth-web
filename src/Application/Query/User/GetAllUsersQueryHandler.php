<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\User;

use Squidmin\Application\DTO\UserDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\User\UserRepositoryInterface;

final class GetAllUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @return UserDTO[]
     */
    public function handle(QueryInterface $query): array
    {
        if (!$query instanceof GetAllUsersQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $users = $this->userRepository->findAll();

        return array_map(function ($user) {
            return new UserDTO(
                $user->getId(),
                $user->getName()->getValue(),
                $user->getEmail()->getValue(),
                $user->isAdministrator(),
                $user->getEmailVerifiedAt(),
                $user->getCreatedAt(),
                $user->getUpdatedAt()
            );
        }, $users);
    }
}
