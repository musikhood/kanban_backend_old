<?php

namespace App\Board\Domain\Model\Command;

use App\Shared\Domain\Cqrs\CommandInterface;

readonly class CreateColumnCommand implements CommandInterface
{
    public function __construct(
        private string $userId,
        private string $boardId,
        private string $name,
    )
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
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