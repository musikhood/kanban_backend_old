<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Dto\FindUserResponseDto;
use App\Account\Application\Model\Query\FindUserQuery;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use App\Account\Application\Exception\UserNotFoundException;
use App\Account\Domain\Repository\UserRepositoryInterface;
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
    public function __invoke(FindUserQuery $findUserQuery): FindUserResponseDto
    {
        $user = $this->userRepository->findOneBy(['id'=>$findUserQuery->getUserId()]);

        if (!$user){
            throw new UserNotFoundException();
        }

        return new FindUserResponseDto(
            $user->id(),
            $user->email(),
            $user->getRoles()
        );
    }
}