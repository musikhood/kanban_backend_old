<?php

namespace App\Board\Domain\Model\Command;

use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Shared\Domain\Cqrs\CommandInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class UpdateBoardCommand implements CommandInterface
{
    public function __construct(
        private UserId $userId,
        private BoardId $boardId,
        private BoardName $boardName
    )
    {
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getBoardName(): BoardName
    {
        return $this->boardName;
    }
}