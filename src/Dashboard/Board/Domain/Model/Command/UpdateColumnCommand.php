<?php

namespace App\Dashboard\Board\Domain\Model\Command;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\Cqrs\CommandInterface;

readonly class UpdateColumnCommand implements CommandInterface
{
    public function __construct(
        private AccountId   $userId,
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

    public function getUserId(): AccountId
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