<?php

namespace App\Board\Domain\Model\Command;

use App\Shared\Domain\Cqrs\CommandInterface;

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