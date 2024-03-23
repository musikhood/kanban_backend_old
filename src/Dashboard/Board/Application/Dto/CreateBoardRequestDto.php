<?php

namespace App\Dashboard\Board\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateBoardRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}