<?php

namespace App\Account\Application\Model\Query;

use App\Shared\Domain\Cqrs\QueryInterface;

readonly class FindAccountQuery implements QueryInterface
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