<?php

namespace App\Account\Domain\Event;

use App\Account\Domain\Entity\AccountId;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AccountCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly AccountId $accountId,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }

}