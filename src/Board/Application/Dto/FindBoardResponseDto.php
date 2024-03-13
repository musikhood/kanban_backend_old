<?php

namespace App\Board\Application\Dto;

use Symfony\Component\Serializer\Attribute\MaxDepth;

readonly class FindBoardResponseDto
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