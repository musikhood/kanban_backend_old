<?php

namespace App\Board\Application\Dto;

readonly class UpdateColumnRequestDto
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