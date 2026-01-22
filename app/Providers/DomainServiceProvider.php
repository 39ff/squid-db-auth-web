<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Squidmin\Application\Command\AllowedIp\AddAllowedIpCommandHandler;
use Squidmin\Application\Command\AllowedIp\RemoveAllowedIpCommandHandler;
use Squidmin\Application\Command\SquidUser\CreateSquidUserCommandHandler;
use Squidmin\Application\Command\SquidUser\DeleteSquidUserCommandHandler;
use Squidmin\Application\Command\SquidUser\DisableSquidUserCommandHandler;
use Squidmin\Application\Command\SquidUser\EnableSquidUserCommandHandler;
use Squidmin\Application\Command\SquidUser\ModifySquidUserCommandHandler;
use Squidmin\Application\Command\User\CreateUserCommandHandler;
use Squidmin\Application\Command\User\DeleteUserCommandHandler;
use Squidmin\Application\Command\User\ModifyUserCommandHandler;
use Squidmin\Application\Query\AllowedIp\GetAllowedIpQueryHandler;
use Squidmin\Application\Query\AllowedIp\GetAllowedIpsByOwnerQueryHandler;
use Squidmin\Application\Query\AllowedIp\SearchAllowedIpsQueryHandler;
use Squidmin\Application\Query\SquidUser\GetSquidUserQueryHandler;
use Squidmin\Application\Query\SquidUser\GetSquidUsersByOwnerQueryHandler;
use Squidmin\Application\Query\SquidUser\SearchSquidUsersQueryHandler;
use Squidmin\Application\Query\User\GetAllUsersQueryHandler;
use Squidmin\Application\Query\User\GetUserQueryHandler;
use Squidmin\Application\Query\User\SearchUsersQueryHandler;
use Squidmin\Domain\AllowedIp\AllowedIpRepositoryInterface;
use Squidmin\Domain\SquidUser\SquidUserRepositoryInterface;
use Squidmin\Domain\User\UserRepositoryInterface;
use Squidmin\Infrastructure\Persistence\Eloquent\EloquentAllowedIpRepository;
use Squidmin\Infrastructure\Persistence\Eloquent\EloquentSquidUserRepository;
use Squidmin\Infrastructure\Persistence\Eloquent\EloquentUserRepository;

final class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register Repositories
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(SquidUserRepositoryInterface::class, EloquentSquidUserRepository::class);
        $this->app->bind(AllowedIpRepositoryInterface::class, EloquentAllowedIpRepository::class);

        // Register User Command Handlers
        $this->app->bind(CreateUserCommandHandler::class);
        $this->app->bind(ModifyUserCommandHandler::class);
        $this->app->bind(DeleteUserCommandHandler::class);

        // Register User Query Handlers
        $this->app->bind(GetUserQueryHandler::class);
        $this->app->bind(GetAllUsersQueryHandler::class);
        $this->app->bind(SearchUsersQueryHandler::class);

        // Register SquidUser Command Handlers
        $this->app->bind(CreateSquidUserCommandHandler::class);
        $this->app->bind(ModifySquidUserCommandHandler::class);
        $this->app->bind(DeleteSquidUserCommandHandler::class);
        $this->app->bind(EnableSquidUserCommandHandler::class);
        $this->app->bind(DisableSquidUserCommandHandler::class);

        // Register SquidUser Query Handlers
        $this->app->bind(GetSquidUserQueryHandler::class);
        $this->app->bind(GetSquidUsersByOwnerQueryHandler::class);
        $this->app->bind(SearchSquidUsersQueryHandler::class);

        // Register AllowedIp Command Handlers
        $this->app->bind(AddAllowedIpCommandHandler::class);
        $this->app->bind(RemoveAllowedIpCommandHandler::class);

        // Register AllowedIp Query Handlers
        $this->app->bind(GetAllowedIpQueryHandler::class);
        $this->app->bind(GetAllowedIpsByOwnerQueryHandler::class);
        $this->app->bind(SearchAllowedIpsQueryHandler::class);
    }

    public function boot(): void
    {
        //
    }
}
