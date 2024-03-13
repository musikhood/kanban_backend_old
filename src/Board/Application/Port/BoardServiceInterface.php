<?php

namespace App\Board\Application\Port;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
interface BoardServiceInterface
{
    public function findBoard(string $boardId): FindBoardResponseDto;
    public function createBoard(string $boardName): CreateBoardResponseDto;
}