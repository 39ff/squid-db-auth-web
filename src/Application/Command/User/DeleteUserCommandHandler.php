<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\User;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\User\UserRepositoryInterface;

final class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof DeleteUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $user = $this->userRepository->findById($command->getUserId());
        if ($user === null) {
            throw new \DomainException('User not found');
        }

        $user->delete();
        $this->userRepository->delete($user);
    }
}
