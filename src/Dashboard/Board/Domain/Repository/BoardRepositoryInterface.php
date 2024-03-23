<?php

namespace App\Dashboard\Board\Domain\Repository;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\User\Domain\Entity\UserId;

interface BoardRepositoryInterface
{
    public function save(Board $board): void;
    public function findByUserId(UserId $userId): array;
    public function findOneById(BoardId $boardId): ?Board;
}