<?php

namespace App\Board\Application\Dto;

readonly class FindBoardResponseDto
{
    public function __construct(
        private string $boardName,
        private string $userId
    )
    {
    }

    public function getBoardName(): string
    {
        return $this->boardName;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}