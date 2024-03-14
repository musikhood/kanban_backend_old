<?php

namespace App\Board\Application\Model\Query;

use App\Shared\Application\Cqrs\QueryInterface;
use App\User\Domain\Entity\User;

readonly class FindBoardQuery implements QueryInterface
{
    public function __construct(
        private string $boardId,
        private User $user
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }
}