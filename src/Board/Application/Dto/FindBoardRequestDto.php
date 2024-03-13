<?php

namespace App\Board\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;
readonly class FindBoardRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $boardId
    )
    {
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }
}