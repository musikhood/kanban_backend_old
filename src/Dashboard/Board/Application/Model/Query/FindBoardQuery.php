<?php

namespace App\Dashboard\Board\Application\Model\Query;

use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Application\Cqrs\QueryInterface;

readonly class FindBoardQuery implements QueryInterface
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