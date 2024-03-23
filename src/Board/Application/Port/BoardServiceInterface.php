<?php

namespace App\Board\Application\Port;

use App\Account\Domain\Entity\AccountId;
use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Board\Application\Dto\UpdateBoardResponseDto;
use App\Board\Application\Dto\UpdateColumnResponseDto;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Entity\ColumnColor;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Entity\ColumnName;

interface BoardServiceInterface
{
    public function findBoard(AccountId $userId): FindBoardResponseDto;
    public function findSingleBoard(AccountId $userId, BoardId $boardId): FindSingleBoardResponseDto;
    public function createBoard(AccountId $userId, BoardName $boardName): CreateBoardResponseDto;
    public function updateBoard(AccountId $userId, BoardId $boardId, BoardName $boardName): UpdateBoardResponseDto;
    public function addColumn(AccountId $userId, BoardId $boardId, ColumnName $columnName, ColumnColor $columnColor): CreateColumnResponseDto;
    public function updateColumn(AccountId $userId, BoardId $boardId, ColumnId $columnId, ColumnName $columnName, ColumnColor $columnColor): UpdateColumnResponseDto;
}