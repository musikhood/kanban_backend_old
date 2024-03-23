<?php

namespace App\Account\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;
use App\User\Domain\Entity\UserEmail;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly string $userEmail,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

}