<?php

namespace App\User\Application\Service;

use App\Shared\Application\Bus\BusInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\User\Application\Dto\CreateUserResponseDto;
use App\User\Application\Model\Command\CreateUserCommand;
use App\User\Application\Port\UserServiceInterface;
use SensitiveParameter;
use Throwable;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function createUser(string $name, array $roles, #[SensitiveParameter] string $password): CreateUserResponseDto
    {
        $createUserCommand = new CreateUserCommand(
            $name,
            $roles,
            $password
        );

        $this->commandBus->dispatch($createUserCommand);

        return new CreateUserResponseDto('User created successfully');
    }
}