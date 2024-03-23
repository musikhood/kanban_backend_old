<?php

namespace App\Account\Application\Model\Query;

use App\Shared\Domain\Cqrs\QueryInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class FindUserQuery implements QueryInterface
{
    public function __construct(
        private string $userId
    )
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}