<?php

declare(strict_types=1);

namespace Squidmin\Domain\Shared;

interface RepositoryInterface
{
    public function nextIdentity(): int;
}
