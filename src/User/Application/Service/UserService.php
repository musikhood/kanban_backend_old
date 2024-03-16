<?php

namespace App\User\Application\Service;

use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\User\Application\Dto\CreateUserResponseDto;
use App\User\Application\Dto\FindUserResponseDto;
use App\User\Application\Port\UserServiceInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Model\Command\CreateUserCommand;
use App\User\Domain\Model\Query\FindUserQuery;
use SensitiveParameter;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    )
    {
    }

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

    public function findUser(string $userId): FindUserResponseDto
    {

        $user = $this->findUserEntity($userId);

        return new FindUserResponseDto(
            $user->getId(),
            $user->getEmail(),
            $user->getRoles()
        );
    }

    public function findUserEntity(string $userId): User
    {
        $findUserQuery = new FindUserQuery($userId);

        /** @var User $user */
        $user = $this->queryBus->handle($findUserQuery);

        return $user;
    }
}