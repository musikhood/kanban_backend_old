<?php

namespace App\Dashboard\Board\Domain\Model\Query;

use App\Account\Domain\Entity\AccountId;
use App\Shared\Domain\Cqrs\QueryInterface;

readonly class FindBoardQuery implements QueryInterface
{
    public function __construct(
        private AccountId $userId
    )
    {
    }

    public function getUserId(): AccountId
    {
        return $this->userId;
    }
}