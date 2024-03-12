<?php

namespace App\User\Domain\Event;

use App\Shared\Event\DomainEventInterface;
use App\User\Domain\Entity\UserEmail;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly UserEmail $userEmail,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getUserEmail(): UserEmail
    {
        return $this->userEmail;
    }

}