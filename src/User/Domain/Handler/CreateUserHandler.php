<?php

namespace App\User\Domain\Handler;

use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserAlreadyExistException;
use App\User\Domain\Model\Command\CreateUserCommand;
use App\User\Infrastructure\Port\UserRepositoryInterface;
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
        $user = $this->userRepository->findOneBy(['email'=>$createUserCommand->getEmail()]);
        if ($user){
            throw new UserAlreadyExistException();
        }

        $user = User::registerUser(
            $createUserCommand->getEmail(),
            $createUserCommand->getPassword(),
            $createUserCommand->getRoles()
        );

        $this->userRepository->save($user);

        foreach ($user->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}