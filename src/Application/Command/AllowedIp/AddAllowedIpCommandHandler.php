<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\AllowedIp;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\AllowedIp\AllowedIp;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;
use Squidmin\Domain\AllowedIp\ValueObject\IpAddress;
use Squidmin\Domain\User\ValueObject\UserId;

final class AddAllowedIpCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AllowedIpRepositoryInterface $allowedIpRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof AddAllowedIpCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $ipAddress = new IpAddress($command->getIpAddress());
        $ownerId = new UserId($command->getOwnerId());

        if ($this->allowedIpRepository->existsByIpAndOwnerId($ipAddress, $ownerId)) {
            throw new \DomainException('This IP address is already allowed for this user');
        }

        $allowedIp = AllowedIp::add(
            $this->allowedIpRepository->nextIdentity(),
            $ipAddress,
            $ownerId
        );

        $this->allowedIpRepository->save($allowedIp);
    }
}
