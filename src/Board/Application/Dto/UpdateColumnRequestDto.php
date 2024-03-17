<?php

namespace App\Board\Application\Dto;

readonly class UpdateColumnRequestDto
{
    public function __construct(
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