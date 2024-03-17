<?php

namespace App\Board\Application\Port;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\ValueObject\UserId;

interface BoardServiceInterface
{
    public function findBoard(UserId $userId, BoardId $boardId): FindBoardResponseDto;
    public function findBoardEntity(UserId $userId, BoardId $boardId): Board;
    public function createBoard(UserId $userId, BoardName $boardName): CreateBoardResponseDto;
    public function addColumn(UserId $userId, BoardId $boardId, ColumnName $columnName): CreateColumnResponseDto;

}