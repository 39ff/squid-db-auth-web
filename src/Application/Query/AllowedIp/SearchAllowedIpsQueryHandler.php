<?php

declare(strict_types=1);

namespace Squidmin\Application\Query\AllowedIp;

use Squidmin\Application\DTO\AllowedIpDTO;
use Squidmin\Application\Query\QueryHandlerInterface;
use Squidmin\Application\Query\QueryInterface;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;
use Squidmin\Domain\User\ValueObject\UserId;

final class SearchAllowedIpsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly AllowedIpRepositoryInterface $allowedIpRepository
    ) {
    }

    /**
     * @return AllowedIpDTO[]
     */
    public function handle(QueryInterface $query): array
    {
        if (!$query instanceof SearchAllowedIpsQuery) {
            throw new \InvalidArgumentException('Invalid query type');
        }

        $ownerId = $query->getOwnerId() !== null ? new UserId($query->getOwnerId()) : null;
        $allowedIps = $this->allowedIpRepository->search($query->getCriteria(), $ownerId);

        return array_map(function ($allowedIp) {
            return new AllowedIpDTO(
                $allowedIp->getId(),
                $allowedIp->getIpAddress()->getValue(),
                $allowedIp->getOwnerId()->getValue(),
                $allowedIp->getCreatedAt(),
                $allowedIp->getUpdatedAt()
            );
        }, $allowedIps);
    }
}
