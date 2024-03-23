<?php

namespace App\Dashboard\Board\Application\Model\Query;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Application\Cqrs\QueryInterface;

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