<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\User\User;
use Squidmin\Domain\User\UserRepositoryInterface;
use Squidmin\Domain\User\ValueObject\AdministratorRole;
use Squidmin\Domain\User\ValueObject\Email;
use Squidmin\Domain\User\ValueObject\HashedPassword;
use Squidmin\Domain\User\ValueObject\UserName;

final class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof CreateUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $email = new Email($command->getEmail());

        if ($this->userRepository->existsByEmail($email)) {
            throw new \DomainException('User with this email already exists');
        }

        $user = User::create(
            $this->userRepository->nextIdentity(),
            new UserName($command->getName()),
            $email,
            HashedPassword::fromPlainPassword($command->getPassword()),
            new AdministratorRole($command->isAdministrator())
        );

        $this->userRepository->save($user);
    }
}
