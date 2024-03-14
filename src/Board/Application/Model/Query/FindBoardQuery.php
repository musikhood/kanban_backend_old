<?php

namespace App\Board\Application\Model\Query;

use App\Shared\Application\Cqrs\QueryInterface;
use App\User\Domain\Entity\User;

readonly class FindBoardQuery implements QueryInterface
{
    public function __construct(
        private string $boardId,
        private string $userId
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
}