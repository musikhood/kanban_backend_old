<?php

namespace App\Board\Application\Dto;

readonly class UpdateBoardRequestDto
{
    public function __construct(
        private string $name
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}