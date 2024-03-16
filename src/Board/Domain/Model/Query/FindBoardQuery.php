<?php

namespace App\Board\Domain\Model\Query;

use App\Shared\Domain\Cqrs\QueryInterface;

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