<?php

namespace App\User\Domain\Handler;

use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Model\Query\FindUserQuery;
use App\User\Domain\RepositoryPort\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindUserHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(FindUserQuery $findUserQuery): ?User
    {
        $user = $this->userRepository->findOneBy(['id'=>$findUserQuery->getUserId()]);

        if (!$user){
            throw new UserNotFoundException();
        }

        return $user;
    }
}