<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\SquidUser;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\SquidUser\SquidUser;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;
use Squidmin\Domain\SquidUser\ValueObject\Comment;
use Squidmin\Domain\SquidUser\ValueObject\Fullname;
use Squidmin\Domain\SquidUser\ValueObject\SquidPassword;
use Squidmin\Domain\SquidUser\ValueObject\SquidUsername;
use Squidmin\Domain\User\ValueObject\UserId;

final class CreateSquidUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly SquidUserRepositoryInterface $squidUserRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof CreateSquidUserCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $username = new SquidUsername($command->getUsername());

        if ($this->squidUserRepository->existsByUsername($username)) {
            throw new \DomainException('Squid user with this username already exists');
        }

        $squidUser = SquidUser::create(
            $this->squidUserRepository->nextIdentity(),
            $username,
            new SquidPassword($command->getPassword()),
            new UserId($command->getOwnerId()),
            new Fullname($command->getFullname()),
            new Comment($command->getComment())
        );

        $this->squidUserRepository->save($squidUser);
    }
}
