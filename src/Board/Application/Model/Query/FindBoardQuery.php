<?php

namespace App\Board\Application\Model\Query;

use App\Shared\Application\Cqrs\QueryInterface;

readonly class FindBoardQuery implements QueryInterface
{
    public function __construct(
        private string $boardId
    )
    {
    }

    public function getBoardId(): string
    {
        return $this->boardId;
    }
}