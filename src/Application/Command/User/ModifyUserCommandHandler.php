<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\User\UserRepositoryInterface;
use Squidmin\Domain\User\ValueObject\AdministratorRole;
use Squidmin\Domain\User\ValueObject\Email;
use Squidmin\Domain\User\ValueObject\HashedPassword;
use Squidmin\Domain\User\ValueObject\UserName;

final class ModifyUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof ModifyUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $user = $this->userRepository->findById($command->getUserId());
        if ($user === null) {
            throw new \DomainException('User not found');
        }

        $password = $command->getPassword() !== null
            ? HashedPassword::fromPlainPassword($command->getPassword())
            : null;

        $role = $command->isAdministrator() !== null
            ? new AdministratorRole($command->isAdministrator())
            : null;

        $user->modify(
            new UserName($command->getName()),
            new Email($command->getEmail()),
            $password,
            $role
        );

        $this->userRepository->save($user);
    }
}
