<?php

namespace App\Board\Application\Model\Query;

use App\Board\Domain\Entity\BoardId;
use App\Shared\Application\Cqrs\QueryInterface;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Domain\Entity\User;

readonly class FindBoardQuery implements QueryInterface
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