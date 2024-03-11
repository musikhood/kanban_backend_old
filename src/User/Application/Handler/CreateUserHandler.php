<?php

namespace App\User\Application\Handler;

use App\User\Application\Model\Command\CreateUserCommand;
use App\User\Domain\Entity\User;
use App\User\Domain\RepositoryPort\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface  $userRepository,
        private EventDispatcherInterface $eventDispatcher,
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function __invoke(CreateUserCommand $createUserCommand)
    {
        $user = User::registerUser($createUserCommand);
        $hashedPassword =
            $this->userPasswordHasher->hashPassword(
                $user,
                $createUserCommand->getPassword()
            );
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);

        foreach ($user->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}