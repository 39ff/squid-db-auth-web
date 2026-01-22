<?php

declare(strict_types=1);

namespace Squidmin\Application\Query;

interface QueryHandlerInterface
{
    /**
     * @return mixed
     */
    public function handle(QueryInterface $query);
}
