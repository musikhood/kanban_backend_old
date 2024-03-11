<?php

namespace App\User\Domain\Event;

use App\Shared\Event\DomainEventInterface;
use App\User\Application\Model\Command\CreateUserCommand;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly CreateUserCommand $createUserCommand,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getCreateUserCommand(): CreateUserCommand
    {
        return $this->createUserCommand;
    }
}