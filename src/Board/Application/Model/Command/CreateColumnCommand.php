<?php

namespace App\Board\Application\Model\Command;

use App\Board\Domain\Entity\Board;
use App\Shared\Application\Cqrs\CommandInterface;

readonly class CreateColumnCommand implements CommandInterface
{
    public function __construct(
        private Board $board,
        private string $name,
    )
    {
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getName(): string
    {
        return $this->name;
    }
}