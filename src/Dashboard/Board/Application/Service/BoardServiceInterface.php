<?php

namespace App\Dashboard\Board\Application\Service;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\User\Domain\Entity\UserId;

interface BoardServiceInterface
{
    public function findBoardEntity(UserId $userId, BoardId $boardId): Board;
}