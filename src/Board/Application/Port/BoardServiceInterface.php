<?php

namespace App\Board\Application\Port;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Domain\Entity\Board;

interface BoardServiceInterface
{
    public function findBoard(string $userId, string $boardId): FindBoardResponseDto;
    public function findBoardEntity(string $userId, string $boardId): Board;
    public function createBoard(string $userId, string $boardName): CreateBoardResponseDto;
    public function addColumn(string $userId, string $boardId, string $columnName): CreateColumnResponseDto;

}