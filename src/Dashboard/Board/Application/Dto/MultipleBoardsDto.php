<?php

namespace App\Dashboard\Board\Application\Dto;

readonly class MultipleBoardsDto implements \JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return [
            'boards' => $this->boards
        ];
    }
}