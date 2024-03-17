<?php

namespace App\User\Application\Model\Query;

use App\Shared\Application\Cqrs\QueryInterface;
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