<?php

namespace App\Board\Domain\Model\Command;

use App\Account\Domain\Entity\AccountId;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Shared\Domain\Cqrs\CommandInterface;

readonly class UpdateBoardCommand implements CommandInterface
{
    public function __construct(
        private AccountId $userId,
        private BoardId   $boardId,
        private BoardName $boardName
    )
    {
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }

    public function getUserId(): AccountId
    {
        return $this->userId;
    }

    public function getBoardName(): BoardName
    {
        return $this->boardName;
    }
}