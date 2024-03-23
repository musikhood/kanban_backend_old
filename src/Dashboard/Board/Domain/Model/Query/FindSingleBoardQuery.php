<?php

namespace App\Dashboard\Board\Domain\Model\Query;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Shared\Domain\Cqrs\QueryInterface;

readonly class FindSingleBoardQuery implements QueryInterface
{
    public function __construct(
        private BoardId $boardId,
        private AccountId $userId
    )
    {
    }

    public function getUserId(): AccountId
    {
        return $this->userId;
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }
}