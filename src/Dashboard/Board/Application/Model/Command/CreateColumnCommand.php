<?php

namespace App\Dashboard\Board\Application\Model\Command;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\Cqrs\CommandInterface;

readonly class CreateColumnCommand implements CommandInterface
{
    public function __construct(
        private AccountId   $userId,
        private BoardId     $boardId,
        private ColumnName  $name,
        private ColumnColor $color
    )
    {
    }

    public function getColor(): ColumnColor
    {
        return $this->color;
    }


    public function getUserId(): AccountId
    {
        return $this->userId;
    }

    public function getBoardId(): BoardId
    {
        return $this->boardId;
    }

    public function getName(): ColumnName
    {
        return $this->name;
    }
}