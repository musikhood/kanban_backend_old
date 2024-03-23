<?php

namespace App\Dashboard\User\Application\Model\Command;

use App\Account\Domain\Entity\AccountId;
use App\Shared\Domain\Cqrs\CommandInterface;

readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        private AccountId $accountId
    )
    {
    }

    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }
}