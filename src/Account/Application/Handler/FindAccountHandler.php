<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Dto\FindAccountResponseDto;
use App\Account\Application\Model\Query\FindAccountQuery;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use App\Account\Application\Exception\AccountNotFoundException;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindAccountHandler implements QueryHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @throws AccountNotFoundException
     */
    public function __invoke(FindAccountQuery $findUserQuery): FindAccountResponseDto
    {
        $user = $this->userRepository->findOneBy(['id'=>$findUserQuery->getUserId()]);

        if (!$user){
            throw new AccountNotFoundException();
        }

        return new FindAccountResponseDto(
            $user->id(),
            $user->email(),
            $user->getRoles()
        );
    }
}