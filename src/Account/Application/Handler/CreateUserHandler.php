<?php

namespace App\Account\Application\Handler;

use App\Account\Application\Exception\UserAlreadyExistException;
use App\Account\Application\Model\Command\CreateUserCommand;
use App\Account\Domain\Entity\Account;
use App\Account\Domain\Entity\AccountId;
use App\Account\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface  $userRepository,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * @throws UserAlreadyExistException
     */
    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $account = $this->userRepository->findOneBy(['email'=>$createUserCommand->getEmail()]);
        if ($account){
            throw new UserAlreadyExistException();
        }

        $account = Account::registerAccount(
            new AccountId(Uuid::uuid4()->toString()),
            $createUserCommand->getEmail(),
            $createUserCommand->getPassword(),
            $createUserCommand->getRoles()
        );

        $this->userRepository->save($account);

        foreach ($account->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}