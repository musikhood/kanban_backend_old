<?php

namespace App\User\Domain\Model\Query;

use App\Shared\Domain\Cqrs\QueryInterface;

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