<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;

final class EnableSquidUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof EnableSquidUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $squidUser = $this->squidUserRepository->findById($command->getSquidUserId());
        if ($squidUser === null) {
            throw new \DomainException('Squid user not found');
        }

        $squidUser->enable();
        $this->squidUserRepository->save($squidUser);
    }
}
