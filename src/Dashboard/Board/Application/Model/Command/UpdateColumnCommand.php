<?php

namespace App\Dashboard\Board\Application\Model\Command;

use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnId;
use App\Dashboard\Board\Domain\Entity\ValueObject\ColumnName;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Application\Cqrs\CommandInterface;

readonly class UpdateColumnCommand implements CommandInterface
{
    public function __construct(
        private UserId   $userId,
        private BoardId     $boardId,
        private ColumnId    $columnId,
        private ColumnName  $columnName,
        private ColumnColor $columnColor
    )
    {
    }

    public function getColumnColor(): ColumnColor
    {
        return $this->columnColor;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }

    public function getColumnId(): ColumnId
    {
        return $this->columnId;
    }

    public function getColumnName(): ColumnName
    {
        return $this->columnName;
    }
}