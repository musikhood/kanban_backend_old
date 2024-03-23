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

    public function boards(): array
    {
        return $this->boards;
    }
}