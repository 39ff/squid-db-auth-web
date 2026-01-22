<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;
use Squidmin\Domain\SquidUser\ValueObject\Comment;
use Squidmin\Domain\SquidUser\ValueObject\Fullname;
use Squidmin\Domain\SquidUser\ValueObject\SquidPassword;
use Squidmin\Domain\SquidUser\ValueObject\SquidUsername;

final class ModifySquidUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof ModifySquidUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $squidUser = $this->squidUserRepository->findById($command->getSquidUserId());
        if ($squidUser === null) {
            throw new \DomainException('Squid user not found');
        }

        $squidUser->modify(
            new SquidUsername($command->getUsername()),
            new SquidPassword($command->getPassword()),
            new Fullname($command->getFullname()),
            new Comment($command->getComment())
        );

        $this->squidUserRepository->save($squidUser);
    }
}
