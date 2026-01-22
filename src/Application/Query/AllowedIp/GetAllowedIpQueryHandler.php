<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\AllowedIp;

use Squidmin\Application\DTO\AllowedIpDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;

final class GetAllowedIpQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly AllowedIpRepositoryInterface $allowedIpRepository
    ) {
    }

    public function handle(QueryInterface $query): ?AllowedIpDTO
    {
        if (!$query instanceof GetAllowedIpQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $allowedIp = $this->allowedIpRepository->findById($query->getAllowedIpId());
        if ($allowedIp === null) {
            return null;
        }

        return new AllowedIpDTO(
            $allowedIp->getId(),
            $allowedIp->getIpAddress()->getValue(),
            $allowedIp->getOwnerId()->getValue(),
            $allowedIp->getCreatedAt(),
            $allowedIp->getUpdatedAt()
        );
    }
}
