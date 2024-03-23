<?php

namespace App\Dashboard\Board\Application\Dto;
readonly class FindSingleBoardResponseDto
{
    public function __construct(
        private string $id,
        private string $user,
        private string $name,
        private array $columns
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}