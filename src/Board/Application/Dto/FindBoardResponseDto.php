<?php

namespace App\Board\Application\Dto;

readonly class FindBoardResponseDto
{
    public function __construct(
        private string $boardName,
        private string $user
    )
    {
    }

    public function getBoardName(): string
    {
        return $this->boardName;
    }

    public function getUser(): string
    {
        return $this->user;
    }
}