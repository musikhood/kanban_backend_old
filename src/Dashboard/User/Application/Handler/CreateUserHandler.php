<?php

namespace App\Dashboard\User\Application\Handler;

use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Dashboard\User\Application\Model\Command\CreateUserCommand;
use App\Dashboard\User\Domain\Entity\User;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Dashboard\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface    $userRepository,
        private EventDispatcherInterface   $eventDispatcher
    )
    {
    }
    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $user = User::createUser(
            new UserId(Uuid::uuid4()->toString()),
            $createUserCommand->getAccountId()
        );

        $this->userRepository->save($user);

        foreach ($user->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}