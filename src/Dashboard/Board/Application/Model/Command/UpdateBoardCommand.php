<?php

namespace App\Dashboard\Board\Application\Model\Command;

use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardName;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Application\Cqrs\CommandInterface;

readonly class UpdateBoardCommand implements CommandInterface
{
    public function __construct(
        private UserId $userId,
        private BoardId   $boardId,
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