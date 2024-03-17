<?php

namespace App\Board\Application\Port;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Board\Application\Dto\UpdateColumnResponseDto;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\ValueObject\UserId;

interface BoardServiceInterface
{
    public function findBoard(UserId $userId): FindBoardResponseDto;
    public function findSingleBoard(UserId $userId, BoardId $boardId): FindSingleBoardResponseDto;
    public function findSingleBoardEntity(UserId $userId, BoardId $boardId): Board;
    public function createBoard(UserId $userId, BoardName $boardName): CreateBoardResponseDto;
    public function addColumn(UserId $userId, BoardId $boardId, ColumnName $columnName): CreateColumnResponseDto;
    public function updateColumn(UserId $userId, BoardId $boardId, ColumnId $columnId, ColumnName $columnName): UpdateColumnResponseDto;
}