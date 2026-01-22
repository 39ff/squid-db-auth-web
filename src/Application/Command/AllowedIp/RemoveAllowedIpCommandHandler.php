<?php

declare(strict_types=1);

namespace Squidmin\Application\Command\AllowedIp;

use Squidmin\Application\Command\CommandHandlerInterface;
use Squidmin\Application\Command\CommandInterface;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;

final class RemoveAllowedIpCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AllowedIpRepositoryInterface $allowedIpRepository
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof RemoveAllowedIpCommand) {
            throw new \InvalidArgumentException('Invalid command type');
        }

        $allowedIp = $this->allowedIpRepository->findById($command->getAllowedIpId());
        if ($allowedIp === null) {
            throw new \DomainException('Allowed IP not found');
        }

        $allowedIp->remove();
        $this->allowedIpRepository->delete($allowedIp);
    }
}
