<?php

namespace App\Dashboard\User\Domain\Entity;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\User\Domain\Event\UserCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId $id,
        private AccountId $accountId
    )
    {
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function accountId(): AccountId
    {
        return $this->accountId;
    }

    public function updateAccountId(AccountId $accountId): void{
        $this->accountId = $accountId;
    }

    public static function createUser(UserId $id, AccountId $accountId): self{
        $user = new self($id, $accountId);

        $user->recordDomainEvent(new UserCreatedEvent($id));

        return $user;
    }
}