<?php

namespace App\User\Application\Model\Query;

use App\Shared\Application\Cqrs\QueryInterface;

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