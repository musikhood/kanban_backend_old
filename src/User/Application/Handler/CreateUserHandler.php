<?php

namespace App\User\Application\Handler;

use App\Shared\Application\Cqrs\CommandHandlerInterface;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Application\Exception\UserAlreadyExistException;
use App\User\Application\Model\Command\CreateUserCommand;
use App\User\Domain\Entity\User;
use App\User\Domain\RepositoryPort\UserRepositoryInterface;
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
        $user = $this->userRepository->findOneBy(['email'=>$createUserCommand->getEmail()]);
        if ($user){
            throw new UserAlreadyExistException();
        }

        $user = User::registerUser(
            new UserId(Uuid::uuid4()->toString()),
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