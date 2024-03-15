<?php

namespace App\Board\Application\Model\Command;

use App\Shared\Application\Cqrs\CommandInterface;

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