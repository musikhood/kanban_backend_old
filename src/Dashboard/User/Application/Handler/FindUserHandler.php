<?php

namespace App\Dashboard\User\Application\Handler;

use App\Dashboard\User\Application\Dto\UserDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Dashboard\User\Domain\Exception\UserNotFoundException;
use App\Dashboard\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindUserHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(FindUserQuery $findUserQuery): UserDto
    {
        $user = $this->userRepository->findOneByAccountId($findUserQuery->getAccountId());

        if (!$user){
            throw new UserNotFoundException();
        }

        return new UserDto(
            $user->id()
        );
    }
}