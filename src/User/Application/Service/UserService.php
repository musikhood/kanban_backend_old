<?php

namespace App\User\Application\Service;

use App\Shared\Application\Bus\CQBus;
use App\User\Application\Dto\CreateUserResponseDto;
use App\User\Application\Model\Command\CreateUserCommand;
use App\User\Application\Port\UserServiceInterface;
use SensitiveParameter;
use Throwable;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private CQBus $bus
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

        $this->bus->dispatch($createUserCommand);

        return new CreateUserResponseDto('User created successfully');
    }
}