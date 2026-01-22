<?php

declare(strict_types=1);

namespace Squidmin\Application\Command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
