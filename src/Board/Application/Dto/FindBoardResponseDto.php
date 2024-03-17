<?php

namespace App\Board\Application\Dto;

readonly class FindBoardResponseDto
{
    /** @param array<FindSingleBoardResponseDto> $boards */
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