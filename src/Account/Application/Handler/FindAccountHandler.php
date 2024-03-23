<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Dto\AccountDto;
use App\Account\Application\Model\Query\FindAccountQuery;
use App\Account\Domain\Entity\AccountId;
use App\Shared\Application\Cqrs\QueryHandlerInterface;
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
    public function __invoke(FindAccountQuery $findAccountQuery): AccountDto
    {
        $id = new AccountId($findAccountQuery->getAccountId());
        $account = $this->accountRepository->findOneById($id);

        if (!$account){
            throw new AccountNotFoundException();
        }

        return new AccountDto(
            $account->id(),
            $account->email(),
            $account->roles()
        );
    }
}