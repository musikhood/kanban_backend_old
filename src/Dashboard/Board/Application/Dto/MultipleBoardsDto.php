<?php

namespace App\Dashboard\Board\Application\Dto;

readonly class MultipleBoardsDto
{
    /** @param array<BoardDto> $boards */
    public function __construct(
        private array $boards
    )
    {
    }

    public function getBoards(): array
    {
        return $this->boards;
    }
}