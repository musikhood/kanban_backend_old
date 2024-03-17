<?php

namespace App\Board\Application\Dto;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateColumnRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $name,

        private string $color
    )
    {
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getName(): string
    {
        return $this->name;
    }
}