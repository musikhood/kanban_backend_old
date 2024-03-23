<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Dto\FindAccountResponseDto;
use App\Account\Application\Model\Query\FindAccountQuery;
use App\Account\Domain\Entity\AccountId;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use App\Account\Application\Exception\AccountNotFoundException;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindAccountHandler implements QueryHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    )
    {
    }

    /**
     * @throws AccountNotFoundException
     */
    public function __invoke(FindAccountQuery $findAccountQuery): FindAccountResponseDto
    {
        $id = new AccountId($findAccountQuery->getAccountId());
        $account = $this->accountRepository->findOneBy(['id'=>$id]);

        if (!$account){
            throw new AccountNotFoundException();
        }

        return new FindAccountResponseDto(
            $account->id(),
            $account->email(),
            $account->roles()
        );
    }
}