<?php

namespace App\Board\Application\Dto;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateColumnRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $boardId,

        #[Assert\NotBlank]
        private string $name
    )
    {
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}