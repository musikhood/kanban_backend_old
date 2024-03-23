<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Exception\AccountAlreadyExistException;
use App\Account\Application\Model\Command\CreateAccountCommand;
use App\Account\Domain\Entity\Account;
use App\Account\Domain\Entity\AccountId;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateAccountHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private EventDispatcherInterface   $eventDispatcher
    )
    {
    }

    /**
     * @throws AccountAlreadyExistException
     */
    public function __invoke(CreateAccountCommand $createUserCommand): void
    {
        $account = $this->accountRepository->findOneByEmail(
            $createUserCommand->getEmail()
        );

        if ($account){
            throw new AccountAlreadyExistException();
        }

        $account = Account::registerAccount(
            new AccountId(Uuid::uuid4()->toString()),
            $createUserCommand->getEmail(),
            $createUserCommand->getPassword(),
            $createUserCommand->getRoles()
        );

        $this->accountRepository->save($account);

        foreach ($account->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}