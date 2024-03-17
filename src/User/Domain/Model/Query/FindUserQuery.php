<?php

namespace App\User\Domain\Model\Query;

use App\Shared\Domain\Cqrs\QueryInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class FindUserQuery implements QueryInterface
{
    public function __construct(
        private UserId $userId
    )
    {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}