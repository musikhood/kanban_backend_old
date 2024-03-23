<?php

namespace App\Dashboard\User\Application\Model\Query;

use App\Account\Domain\Entity\AccountId;
use App\Shared\Domain\Cqrs\QueryInterface;

readonly class FindUserQuery implements QueryInterface
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