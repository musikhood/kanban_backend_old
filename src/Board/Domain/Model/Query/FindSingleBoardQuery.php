<?php

namespace App\Board\Domain\Model\Query;

use App\Board\Domain\Entity\BoardId;
use App\Shared\Domain\Cqrs\QueryInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class FindSingleBoardQuery implements QueryInterface
{
    public function __construct(
        private BoardId $boardId,
        private UserId $userId
    )
    {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }
}