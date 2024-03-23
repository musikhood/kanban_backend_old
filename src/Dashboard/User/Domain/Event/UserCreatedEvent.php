<?php

namespace App\Dashboard\User\Domain\Event;

use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly UserId $userId,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

}