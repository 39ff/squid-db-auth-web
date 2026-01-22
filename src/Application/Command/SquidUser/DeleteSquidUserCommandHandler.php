<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;

final class DeleteSquidUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof DeleteSquidUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $squidUser = $this->squidUserRepository->findById($command->getSquidUserId());
        if ($squidUser === null) {
            throw new \DomainException('Squid user not found');
        }

        $squidUser->delete();
        $this->squidUserRepository->delete($squidUser);
    }
}
