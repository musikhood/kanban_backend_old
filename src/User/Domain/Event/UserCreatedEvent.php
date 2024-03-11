<?php

namespace App\User\Domain\Event;

use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly string $email,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}