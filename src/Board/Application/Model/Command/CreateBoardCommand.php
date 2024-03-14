<?php

namespace App\Board\Application\Model\Command;

use App\Shared\Application\Cqrs\CommandInterface;
use App\User\Domain\Entity\User;

readonly class CreateBoardCommand implements CommandInterface
{
    public function __construct(
        private string $name,
        private User $user
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }
}