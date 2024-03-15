<?php

namespace App\Board\Application\Model\Command;

use App\Shared\Application\Cqrs\CommandInterface;

readonly class CreateBoardCommand implements CommandInterface
{
    public function __construct(
        private string $name,
        private string $userId
    )
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}